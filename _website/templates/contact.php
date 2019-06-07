<?php defined('DIR') OR exit;
$email =  'FullName: ' . post('firstname') . '<br />' .
        'E-Mail: ' . post('email') . '<br />' .
        'Message: ' . post('message');

$alert = "";
$postArray = array_fill_keys(array('csrftoken', 'firstname', 'email', 'message', 'captcha'), '');
$postData = $postArray;
$errorData = $postArray;
if (!empty($_POST['csrftoken'])) {
    $alert = '<div class="error">'.l('allfields').'</div>';
    $postData = post($postArray, 'str');

    if (!isset($_SESSION['csrftoken']) || $_SESSION['csrftoken'] != $postData['csrftoken']){
      redirect(href($slug));
    }

    if (filter_var(s('feedback'), FILTER_VALIDATE_EMAIL) || !empty($_SESSION[CAPTCHA_SESSION_ID])) {
        $valid = 1;

        if (strtoupper($postData['captcha']) != strtoupper($_SESSION[CAPTCHA_SESSION_ID])) {
            $alert = '<div class="error">'.l('error').'</div>';
            $valid = 0;
        }

        if (!$postData["email"]) {
            $alert = '<div class="error">'.l('emailfieldisrequired').'</div>';
            $valid = 0;
        } else {
            if (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
                $alert = '<div class="error">'.l('emailerror').'</div>';
                $valid = 0;
            }
        }

        if (!$postData["firstname"]) {
            $alert = '<div class="error">'.l('allfields').'</div>';
            $valid = 0;
        }

        if (!$postData["message"]) {
            $alert = '<div class="error">'.l('allfields').'</div>';
            $valid = 0;
        }
        
        if ($valid) {
            unset($postData['csrftoken'], $postData['captcha']);

            require_once '_modules/phpmailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->IsSMTP();
            $mail->Host = 'tripplanner.ge';
            $mail->SMTPAuth = true;
            $mail->Username = 'forget2@tripplanner.ge';
            $mail->Password = 'TJ,+u9Kgu2R^YI0H';
            $mail->From = ' forget2@tripplanner.ge';
            $mail->FromName = $_POST['firstname'];

            $mail->addAddress(s('feedback'));

            $mail->WordWrap = 80;
            $mail->IsHTML(true);
            $mail->Subject = 'Tripplanner.ge - Contact';
            $mail->Body    = $email;
            $mail->AltBody = $email;

            if (!$mail->send())
                $alert = '<div class="error">'.l('error').'</div>';
            else
                $alert = '<div id="alert" class="success">'.l('welldone').'</div>';

            $postData = $postArray;
        }

    } else {
        $alert = '<div id="alert" class="error">'.l('error').'</div>';
    }
}
?>

<div class="InsidePagesHeader">
  <div class="Item" style="background:url('<?=$image1?>');"></div> 
</div>

<div class="TripListPageDiv">
  <div class="TripListInsidePage"> 
    <div class="container">
      <h3 class="PageTitle InsideTitle"><label><?=menu_title(176)?></label></h3>
      <div class="row row0">
        <div class="col s12">
          <div class="Breadcrumb"> 
            <?php echo location();?> 
          </div>

          <div class="ContactPage">
            <div class="row">
              <div class="col-sm-9 ColSm9">
                <div class="Title"><?=l("writeus")?></div>
                <form class="form" role="form" id="form" action="<?php echo href($slug) ?>" method="post">
                  <? if(!empty($alert)) : ?>
                  <div class="alert" style="padding:0; margin: 30px 0 0 0;"><?=$alert?></div>
                  <? endif; ?>
                  <input type="hidden" name="csrftoken" value="<?php echo $_SESSION['csrftoken'] ?>">
                  <div class="ContactForm">
                  <div class="row">
                    <div class="form-group col-sm-6">
                      <div class="MaterialForm">
                        <input type="text" name="firstname" value="" autocomplete="off" />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label><?php echo l('firstname') ?></label>
                      </div>          
                    </div>
                    <div class="form-group col-sm-6">
                      <div class="MaterialForm">
                        <input type="text" name="email" value="" autocomplete="off" />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label><?php echo l('email') ?></label>
                      </div>          
                    </div>

                    <div class="form-group col-sm-12">
                      <div class="MaterialForm">
                        <textarea name="message" autocomplete="off"></textarea> 
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label><?php echo l('message') ?></label>
                      </div>          
                    </div>

                    <div class="form-group col-sm-6">
                      <div class="MaterialForm">
                        <input type="text" name="captcha" value="" autocomplete="off" />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label><?php echo l('entercode') ?></label>
                      </div>          
                    </div>

                    <div class="form-group col-sm-6">
                      <img src="_modules/captcha/captchaImage.php" width="150" height="50" alt="captcha" class="img-responsive" style="padding-top: 10px;" />         
                    </div>

                    

                    <div class="form-group col-sm-12">
                       <button class="GreenCircleButton_4"><?=l("send")?></button>          
                    </div>
                  </div>
                  </div>
                </form>             
              </div>
              <div class="col-sm-3 ColSm3">
                <div class="ContactSidebar RightBackground">
                  <div class="Title"><?=menu_title(176)?></div>
                  <div class="Info">                    
                    <!-- <li><?=s("Address")?></li> -->
                    <li><?=s('Email')?></li>
                    <li><?php echo s('phone');?></li>
                  </div>
                  <div class="ContactSocialLinks">
                    <a href="<?=s("tripfacebook")?>" target="_blank">Facebook</a>
                    <a href="<?=s("tripinstagram")?>" target="_blank">Instagram</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>




<?php if (isset($_POST['csrftoken'])): ?>
<script type="text/javascript">
    $(function(){
        $('html, body').animate({
            scrollTop: $("#form").offset().top
        }, 0);
    });
</script>
<?php endif ?>