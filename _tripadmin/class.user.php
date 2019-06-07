<?php

defined('DIR') OR exit;

class User
{
    private $user = array();
    private $logged = false;
    public $error;

    public function __construct() {
        if (!empty($_SESSION['user'])) {
            $this->user['id'] = $_SESSION['user']['id'];
            $this->user['type'] = $_SESSION['user']['type'];
            $this->user['logindate'] = $_SESSION['user']['logindate'];
            $this->logged = true;
        }
        if (!empty($_SESSION['auth']) && get('auth',0)) {
            $user = db_fetch("SELECT id, type, logindate from ".c("table.site_users")." where id = ".get('auth',0));
            session_regenerate_id();
            $_SESSION['user']['id'] = $user['id'];
            $_SESSION['user']['type'] = $user['type'];
            $_SESSION['user']['logindate'] = $user['logindate'];
            $this->user['id'] = $user['id'];
            $this->user['type'] = $user['type'];
            $this->user['logindate'] = $user['logindate'];
            redirect(href(1));
        }
        if (cookie('user')) {
            $cookie = sha1($_COOKIE['user']);
            $user = db_fetch("SELECT id, type, logindate from ".c("table.site_users")." where `remember` = '{$cookie}'");
            if ($user) {
                $this->user['id'] = $user['id'];
                $this->user['type'] = $user['type'];
                $this->user['logindate'] = $user['logindate'];
                $interval = (int)date('Ymd') - (int)date("Ymd", strtotime($user['logindate']));
                if ($interval > 3)
                    $this->set_cookie();
                $this->logged = true;
            }
        }
    }

    public function data($data) {
        return $this->user[$data];
    }

    public function logged() {
        return $this->logged;
    }

    public function login($email, $password, $remember = false) {
        $user = db_fetch("SELECT id, email, firstname, lastname, type, logindate, active, regcode, password from ".c("table.site_users")." where email = '{$email}'");
        if ($user && password_verify($password, $user['password'])) {
            if ($user['active'] == 1) {
                if (empty($user['regcode'])) {
                    if (isset($_SESSION['tmp_user']))
                        unset($_SESSION['tmp_user']);
                    session_regenerate_id();
                    $_SESSION['user']['id'] = $user['id'];
                    $_SESSION['user']['type'] = $user['type'];
                    $_SESSION['user']['logindate'] = $user['logindate'];
                    $this->user['id'] = $user['id'];
                    $this->user['type'] = $user['type'];
                    $this->user['logindate'] = $user['logindate'];
                    if ($remember) {
                        $this->set_cookie();
                    }
                    $this->logged = true;
                } else {
                    $_SESSION['tmp_user']['id'] = $user['id'];
                    $_SESSION['tmp_user']['email'] = $user['email'];
                    $_SESSION['tmp_user']['firstname'] = $user['firstname'];
                    $_SESSION['tmp_user']['lastname'] = $user['lastname'];
                    $this->error = '<div>'.l('activation.required').'</div><div>'.l('not.recieved').' <a href="'.href(13, array('newtoken' => 1)).'">'.l('send.again').'</a></div>';
                }
            } else {
                $this->error = l('user.suspended');
            }
        } else {
            $this->error = l('err.auth');
        }
    }

    public function set_cookie() {
        $cookie = md5(microtime().rand_string(20, true));
        setcookie('user', $cookie, time()+(60*60*720*4), '/', '', false, true);
        $update = db_update(c("table.site_users"), array('remember' => sha1($cookie), 'logindate' => date('Y-m-d H:i:s')), "WHERE `id` = {$this->user['id']}");
        db_query($update);
    }

    public function logout() {
        $token = md5(date('ihs', strtotime($this->user['logindate'])));
        if (get('token','') == $token) {
            unset($_SESSION['user'], $this->user);
            setcookie('user', '', time()-(60*60*720*4), '/');
            $this->logged = false;
        }
    }

    public function set_error($value) {
        $this->error = $value;
    }
}