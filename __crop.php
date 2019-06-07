<?php

exit();

$img = isset($_GET["img"]) && $_GET["img"]!="" ? $_GET["img"] : null;

if (isset($_GET["n"]) && !empty($_GET["n"])) {

    $n = $_GET["n"];

    $dim = array(

        1 => array("w" => 74, "h" => 288),

        2 => array("w" => 96, "h" => 295),

        3 => array("w" => 74, "h" => 295),

        4 => array("w" => 298, "h" => 607),

        5 => array("w" => 960, "h" => 395),

        6 => array("w" => 220, "h" => 220),

        7 => array("w" => 480, "h" => 395),

        8 => array("w" => 140, "h" => 395),

        9 => array("w" => 480, "h" => 300)

    );

    if (array_key_exists($n, $dim)) {

        $w = $dim[$n]["w"];

        $h = $dim[$n]["h"];

    } else {

        die;

    }

} else {

    die;

}



$parts = explode("/", $img);

$cnt = count($parts)-1;



$ext = substr(strrchr($parts[$cnt], "."), 1);

$img_n = substr($parts[$cnt], 0, strrpos($parts[$cnt], "."));

$dir = array();

$valid = 0;

for ($i=0; $i < $cnt; $i++) { 

    if ($parts[$i] == "files")

        $valid = 1;

    if ($valid == 1)

        $dir[] = $parts[$i];

}

$path = implode("/", $dir)."/".$img_n.".".$ext;

if (!file_exists($path))

    die;

$dir = implode("-", $dir);



if (!in_array($ext, array("jpg", "jpeg", "png", "gif", "JPG", "JPEG", "PNG", "GIF"))) die;



$file_name = $dir."-".$img_n."-".$w."x".$h.".".$ext;

$file_path = "img/".$file_name;



ini_set("gd.jpeg_ignore_warning", 1);

ini_set("memory_limit","10000M");



//header("Content-Type: image/jpeg");

//header("location: " . $img);



if (file_exists($file_path)) {

    header("location: " . $file_path);

} else {

    $src = "img/cropping_".$dir."-".$img_n."-".$w."x".$h.".".$ext;

    copy(str_replace(" ", "%20", $img), $src);

    

// removed copy option    

    make_thumb($src, $w, $h, $file_path, $ext);

    unlink($src);

    header("location: " . $file_path);

}



function make_thumb($img_name, $new_w, $new_h, $new_name = null, $ext)

{

    switch ($ext)

    {

        case "JPEG":

        case "JPG":

        case "jpeg":

        case "jpg":

            $src_img = imagecreatefromjpeg($img_name);

            break;

        case "PNG":

        case "png":

            $src_img = imagecreatefrompng($img_name);

            break;

        case "GIF":

        case "gif":

            $src_img = imagecreatefromgif($img_name);

            break;

        default:

            die;

    }



    $old_w = imagesx($src_img);

    $old_h = imagesy($src_img);



    $new_x = 0;

    $new_y = 0;

    

    if($old_w/$old_h > $new_w/$new_h) {

        $orig_h = $old_h;

        $orig_w = round($new_w * $orig_h / $new_h);

        $new_x = ($old_w - $orig_w) / 2;

    } else {

        $orig_w = $old_w;

        $orig_h = round($new_h * $orig_w / $new_w);

        $new_y = ($old_h - $orig_h) / 2;

    }



/*



    if ($old_w > $old_h)

    {

        $orig_h = $old_h;

        $orig_w = round($new_w * $orig_h / $new_h);

        $new_x = ($old_w - $orig_w) / 2;

    }

    else

    {

        $orig_w = $old_w;

        $orig_h = round($new_h * $orig_w / $new_w);

        $new_y = ($old_h - $orig_h) / 2;

    }



*/



    $dst_img = imagecreatetruecolor($new_w, $new_h);



    $bgcolor = imagecolorallocate($dst_img, 255, 255, 255);

    imagefill($dst_img, 0, 0, $bgcolor);

    

    imagecopyresampled($dst_img, $src_img, 0, 0, $new_x, $new_y, $new_w, $new_h, $orig_w, $orig_h);



    imagejpeg($dst_img, $new_name, 100);



    imagedestroy($dst_img);

    imagedestroy($src_img);

}



?>

