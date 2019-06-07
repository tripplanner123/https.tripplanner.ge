<?php
function generatePassword($length=9, $strength=0) {
	$vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	return $password;
}

$msg = "";
$success=0;
if(isset($_POST["email"])) {
	$res = db_fetch("SELECT count(*) AS cnt FROM `site_users` WHERE email='".db_escape($_POST["email"])."'");
	$cnt = $res["cnt"];
	if(isset($_POST["email"]) && ($_POST["email"]!='') && ($cnt!=0)) {
		$newpass=generatePassword(9, 7);
		$res = db_query("UPDATE `site_users` SET `userpass`='".sha1($newpass)."' WHERE email='".db_escape($_POST["email"])."'");
		$cnt ='giftarea.ge: დავიწყებული პაროლის აღდგენა.<br /><br />';
		$cnt .='თქვენი ახალი პაროლი არის: '.$newpass.'<br /><br />';
		$cnt .='საიტზე ავტორიზაციის შემდგომ რეკომენდებულია პაროლის გამოცვლა.<br /><br />';
		$headers = "Content-type:text/html;charset=utf-8" . "\r\n";
		$headers.= 'From: giftarea.ge' . "\r\n";
		mail($_POST["email"], ' giftarea.ge: ', $cnt, $headers);
		$msg="ელ–ფოსტის მისამართზე '".$_POST["email"]."' გამოგეგზავნათ ახალი პაროლი...";
		$success=1;
	} else {
		if($cnt==0) $msg='ასეთი ელ–ფოსტა არ არის რეგისტრირებული';
		if($_POST["email"]=='') $msg='მიუთითეთ ელ–ფოსტა';
		$success=0;
	}
}

if($success == 1) {
	$this->storage->content = $msg;
} else {
	$this->storage->content = '
	    <div class="page-title"><h2>'.l('restore').'</h2></div>
		<h2>'.$msg.'</h2>
    <div id="page" class="fix">
        <br />
        <form action="'.href(107).'" method="post" name="inputform" id="app">
            <div class="field">
				<label>'.l('contact.email').':</label>
				<input type="text" name="email" value="" class="inp" />
			</div>
			<div class="clear"></div>
            <div class="button-bg right">
				<input type="submit" value="'.l('contact.send').'" class="button" />
			</div>
        </form>
    </div>';
}
?>
