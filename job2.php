<?php 
// function rrmdir($dir) { 
//    if (is_dir($dir)) { 
//      $objects = scandir($dir); 
//      foreach ($objects as $object) { 
//        if ($object != "." && $object != "..") { 
//          if (is_dir($dir."/".$object)){
//            rrmdir($dir."/".$object);
//        	}else{
//        		$arr = explode(".", $object);
//        		$ex = strtolower(end($arr));
//        		echo $dir."/". $object."<br>";
//        	}
//        } 
//      }
//    } 
//  }

// rrmdir("/home3/tripplanner/public_html/_javascript");