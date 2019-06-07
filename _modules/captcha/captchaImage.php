<?php
session_start();
require('php-captcha.inc.php');
$aFonts = array('fonts/VeraBd.ttf', 'fonts/VeraIt.ttf', 'fonts/Vera.ttf');
$oVisualCaptcha = new PhpCaptcha($aFonts, 140, 50);
#$oVisualCaptcha->SetOwnerText('Source: www.vaci.ge');
$oVisualCaptcha->SetWidth(140);
$oVisualCaptcha->Create();
?>