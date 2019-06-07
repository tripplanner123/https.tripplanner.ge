<?php 
// unlink($dir."/".$object); 
function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (is_dir($dir."/".$object)){
           rrmdir($dir."/".$object);
       	}else{
       		$arr = explode(".", $object);
       		$ex = strtolower(end($arr));
       		if($ex=="php" || $ex=="py" || $ex=="zip" || $ex=="rar"){
       			echo $dir."/". $object."<br>";
       			//unlink($dir."/".$object); 
       		}
       	}
       } 
     }
     //rmdir($dir); 
   } 
 }

rrmdir("/home4/tripplanner/public_html/files");
rrmdir("/home4/tripplanner/public_html/img");
rrmdir("/home4/tripplanner/public_html/_website/js");
rrmdir("/home4/tripplanner/public_html/_website/css");
rrmdir("/home4/tripplanner/public_html/_website/fonts");
rrmdir("/home4/tripplanner/public_html/infotour");

rrmdir("/home4/tripplanner/beetrip.ge/files");
rrmdir("/home4/tripplanner/beetrip.ge/img");
rrmdir("/home4/tripplanner/beetrip.ge/_website/js");
rrmdir("/home4/tripplanner/beetrip.ge/_website/css");
rrmdir("/home4/tripplanner/beetrip.ge/_website/fonts");