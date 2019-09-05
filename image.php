<?php 
error_reporting(0);
ini_set('display_errors', 0);

if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}

require_once '_plugins/vendor/autoload.php';
use Intervention\Image\ImageManager;

//WebP

class Image
{
	public function __construct()
	{
		if(!isset($_GET["f"])){ die(); }
		if(!isset($_GET["w"])){ die(); }
		if(!isset($_GET["h"])){ die(); }
	} 

	public function loadimage()
	{
		
		$f = $_GET["f"];
		$w = $_GET["w"];
		$h = $_GET["h"];
		$grey = (isset($_GET["grey"])) ? $_GET["grey"] : false;

		$filename = explode("https://tripplanner.ge/", $f);

		if(!$filename){ exit(); }

		$w = (!is_numeric($w) || $w==0) ? null : $w;
		$h = (!is_numeric($h) || $h==0) ? null : $h;

		$ext = explode(".", $filename[1]);
		$end = strtolower(end($ext));


		if(isset($filename[1]) && file_exists($filename[1]) && ($end=="jpg" || $end=="png" || $end=="gif" || $end=="jpeg")){
			$fileSize = filesize($filename[1]);
			
			$resizeDir = "img/temp/";
			$resizeFileName = $fileSize. "-colorize2-" . $w . "-" . $h . "-". $grey . "-" . str_replace(array("/", " "), "-", $filename[1]);
			$resizePath = $resizeDir . $resizeFileName;
			
			if(!file_exists($resizePath)){		
				$manager = new ImageManager(array('driver' => 'gd'));	//imagick	
				if($grey){
					$manager->make($filename[1])->fit($w, $h)->greyscale()->encode('jpeg', 55)->save($resizePath)->colorize(0, 30, 0);
				}else{
					$manager->make($filename[1])->fit($w, $h)->encode('jpeg', 55)->save($resizePath)->colorize(0, 30, 0);
				}
			}

			header('Content-Type: image/jpeg');
			echo file_get_contents($resizePath);

		}else{
			die("Sorry");
		}
	}

}

$Image = new Image();
$Image->loadimage();