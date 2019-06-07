<?php
    defined('DIR') OR exit;
    $out = array(
        "Error" => array(
            "Code"=>1, 
            "Text"=>l("error"),
            "gErrorRedLine"=>array("popupbox"),
            "Details"=>""
        ),
        "Success"=>array(
            "Code"=>0, 
            "Text"=>"",
            "Details"=>""
        )
    ); 

    if(isset($_GET['fb-callback']) ){
        require_once('_plugins/php-graph-sdk-5.x/src/Facebook/autoload.php'); 
        $fb = new Facebook\Facebook([
            'app_id' => '1985700118125179', // Replace {app-id} with your app id
            'app_secret' => '7a90c0447042b3290718a670f199f028',
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
          $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }

        if (! isset($accessToken)) {
          if ($helper->getError()) {
            // header('HTTP/1.0 401 Unauthorized');
            // echo "Error: " . $helper->getError() . "\n";
            // echo "Error Code: " . $helper->getErrorCode() . "\n";
            // echo "Error Reason: " . $helper->getErrorReason() . "\n";
            // echo "Error Description: " . $helper->getErrorDescription() . "\n";
            header('Location: https://tripplanner.ge');
          } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
          }
          exit;
        }

        $_SESSION['fb_access_token'] = (string) $accessToken;
        
        try {
          $response = $fb->get('/me?fields=id,last_name,first_name,email,birthday', $accessToken);
          
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          echo 'Graph returned an error: ' . $e->getMessage();
          exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          echo 'Facebook SDK returned an error: ' . $e->getMessage();
          exit;
        }
        $user = $response->getGraphUser();
        // print_r($response);
        // exit();

        $sql = "SELECT * FROM `site_users` WHERE `email`='".$user['email']."' AND `deleted`=0";
        $fetch = db_fetch($sql);
        if(isset($fetch['id'])){
            $_SESSION["trip_user"] = $user['email'];
            $_SESSION["trip_user_info"] = $fetch;

            if(isset($_SESSION["cartsession"]))
            {
                $userid = $_SESSION["cartsession"];
                $sql5 = "UPDATE `cart` SET `userid`='".$user['email']."' WHERE `userid`='".$userid."'";
                db_query($sql5);
            }

            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . '/'.l().'/profile';
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $redirect);
            exit();
        }else{
            $name = (isset($user['name'])) ? explode(" ", $user['name']) : "";
            $firstname = (isset($name[0])) ? $name[0] : '';
            $lastname = (isset($name[1])) ? $name[1] : '';
            $sql = "INSERT INTO `site_users` SET `date`='".time()."', `username`='".$user['email']."', `userpass`='".md5(123)."', `email`='".$user['email']."', `firstname`='".$firstname."', `lastname`='".$lastname."'";
            db_query($sql);

            $sql = "SELECT * FROM `site_users` WHERE `email`='".$user['email']."' AND `deleted`=0";
            $fetch = db_fetch($sql);
            $_SESSION["trip_user"] = $user['email'];
            $_SESSION["trip_user_info"] = $fetch;

            if(isset($_SESSION["cartsession"]))
            {
                $userid = $_SESSION["cartsession"];
                $sql5 = "UPDATE `cart` SET `userid`='".$user['email']."' WHERE `userid`='".$userid."'";
                db_query($sql5);
            }

            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . '/'.l().'/profile';
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $redirect);
            exit();
        }
        

        exit();
    }

    if(isset($_GET["sql"])){
        
        exit();
    }
    if(isset($_POST["type"]))
    {
        $type = $_POST["type"];

        switch ($type) {
            case 'insertTransCart':
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["insurance123"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    $successText = "";                
                    $countCartitem = 0;                
                }else if(empty($_POST["startdatetrans"]) || empty($_POST["timeTrans"])){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("datefieldrequired");
                    $successText = "";                
                    $countCartitem = 0;
                }else if(empty($_POST["startplace"]) || empty($_POST["endplace"]) || empty($_POST["km"]) || !is_numeric($_POST["km"]) || $_POST["km"]<=0){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("pleaseselectstartendplace");
                    $successText = "";                
                    $countCartitem = 0; 
                }else if(empty($_POST["guestnumber"]) || !is_numeric($_POST["guestnumber"]) || $_POST["guestnumber"]<=0){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("atleastoneadult");
                    $successText = "";                
                    $countCartitem = 0; 
                }else if(empty($_POST["TransporDropDownId"])){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("transportnotchosen");
                    $successText = "";                
                    $countCartitem = 0; 
                }else if(
                    $_POST['insurance123']==1 && 
                    (
                        empty($_POST["g_insuarance_damzgvevi"]) || 
                        empty($_POST["g_insuarance_dazgveuli"]) || 
                        empty($_POST["g_insuarance_misamarti"]) || 
                        empty($_POST["g_insuarance_dabtarigi"]) || 
                        empty($_POST["g_insuarance_pasporti"]) || 
                        empty($_POST["g_insuarance_piradinomeri"]) || 
                        empty($_POST["g_insuarance_telefonis"]) 
                    )
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("fillinsuredata");
                    $successText = "";                
                    $countCartitem = 0;
                }else{
                    $children = (isset($_POST["children"]) && is_numeric($_POST["children"])) ? $_POST["children"] : 0;
                    $underchildren = (isset($_POST["underchildren"]) && is_numeric($_POST["underchildren"])) ? $_POST["underchildren"] : 0;
                    $children2 = (isset($_POST["children2"]) && is_numeric($_POST["children2"])) ? $_POST["children2"] : 0;
                    $underchildren2 = (isset($_POST["underchildren2"]) && is_numeric($_POST["underchildren2"])) ? $_POST["underchildren2"] : 0;

                    $transport_name1 = "";
                    $transport_name2 = "";

                    $roud1_price = 0;
                    $roud2_price = 0;
                    $sql = "SELECT `price_plus` FROM `catalogs` WHERE `id`='".(int)$_POST["startplace"]."' AND `language`='".$_POST["input_lang"]."' AND `deleted`=0 AND `visibility`=1";
                    $fetch = db_fetch($sql);

                    $sql2 = "SELECT `price_plus` FROM `catalogs` WHERE `id`='".(int)$_POST["endplace"]."' AND `language`='".$_POST["input_lang"]."' AND `deleted`=0 AND `visibility`=1";
                    $fetch2 = db_fetch($sql2);
                    
                    $sql3 = "SELECT `id`, `title`, `price1`, `price2`, `kmlimit` FROM `pages` WHERE `id`='".(int)$_POST['TransporDropDownId']."' AND `deleted`=0 AND `language`='".$_POST["input_lang"]."'";
                    $fetch3 = db_fetch($sql3);
                    
                    $transport_name1 = $fetch3["title"];

                    $km = (float)$_POST['km'];
                    $transport_price_per_km = 0;

                    $totalCrow = (int)$_POST["guestnumber"] + (int)$children + (int)$underchildren;
                    if($km >= $fetch3['kmlimit']){// 200 + კილომეტრი
                        if($totalCrow<=3 && $fetch3['id']==125){// თუ სტუმ. რაოდ <=3 და სედანია არჩეული
                            $transport_price_per_km = (float)$fetch3['price1'];
                        }else if($totalCrow>3 && $fetch3['id']==125){// თუ სტუმრების რაოდენობა > 3 და არჩეულია სედანი
                            $howManyCars = ceil($totalCrow / 3);
                            $transport_price_per_km = (float)$fetch3['price1'] * $howManyCars;
                        }else if($totalCrow<=6 && $fetch3['id']==126){// თუ სტუმ. რაოდ <=6 და მინივენია არჩეული
                            $transport_price_per_km = (float)$fetch3['price1'];
                        }else if($totalCrow>=6 && $fetch3['id']==126){// თუ სტუმრების რაოდენობა > 6 და არჩეულია მინივენი
                            $howManyMinivan = ceil($totalCrow / 6);
                            $transport_price_per_km = (float)$fetch3['price1'] * $howManyMinivan;
                        }else if($totalCrow<=12 && $fetch3['id']==127){// თუ სტუმ. რაოდ <=12 და ავტობუსია არჩეული
                            $transport_price_per_km = (float)$fetch3['price1'];
                        }else if($totalCrow>=12 && $fetch3['id']==127){// თუ სტუმრების რაოდენობა > 12 და არჩეულია ავტობუსი
                            $howManyBus = ceil($totalCrow / 12);
                            $transport_price_per_km = (float)$fetch3['price1'] * $howManyBus;
                        }                       
                    }else{// 200 კილომეტრამდე
                        if($totalCrow<=3 && $fetch3['id']==125){// თუ სტუმ. რაოდ <=3 და სედანია არჩეული
                            $transport_price_per_km = (float)$fetch3['price2'];
                        }else if($totalCrow>3 && $fetch3['id']==125){// თუ სტუმრების რაოდენობა > 3 და არჩეულია სედანი
                            $howManyCars = ceil($totalCrow / 3);
                            $transport_price_per_km = (float)$fetch3['price2'] * $howManyCars;
                        }else if($totalCrow<=6 && $fetch3['id']==126){// თუ სტუმ. რაოდ <=6 და მინივენია არჩეული
                            $transport_price_per_km = (float)$fetch3['price2'];
                        }else if($totalCrow>=6 && $fetch3['id']==126){// თუ სტუმრების რაოდენობა > 6 და არჩეულია მინივენი
                            $howManyMinivan = ceil($totalCrow / 6);
                            $transport_price_per_km = (float)$fetch3['price2'] * $howManyMinivan;
                        }else if($totalCrow<=12 && $fetch3['id']==127){// თუ სტუმ. რაოდ <=12 და ავტობუსია არჩეული
                            $transport_price_per_km = (float)$fetch3['price2'];
                        }else if($totalCrow>=12 && $fetch3['id']==127){// თუ სტუმრების რაოდენობა > 12 და არჩეულია ავტობუსი
                            $howManyBus = ceil($totalCrow / 12);
                            $transport_price_per_km = (float)$fetch3['price2'] * $howManyBus;
                        }
                    }

                    $ten = ($fetch['price_plus']==1) ? 10 : 0;
                    $ten2 = ($fetch2['price_plus']==1) ? 10 : 0;
                    $tenBoth = $ten + $ten2;

                    $totalprice = number_format((float)($km*$transport_price_per_km), 2, ".", "") + $tenBoth;

                    $roud1_price = $totalprice;


                    /* double way start */
                    $startplace2 = "";
                    $endplace2 = "";
                    if(
                        isset($_POST["startplace2"]) && 
                        isset($_POST["endplace2"]) && 
                        isset($_POST["guestnumber2"]) && 
                        isset($_POST["startdatetrans2"]) && 
                        isset($_POST["timeTrans2"]) && 
                        !empty($_POST["startplace2"]) && 
                        !empty($_POST["endplace2"]) && 
                        !empty($_POST["startdatetrans2"]) && 
                        !empty($_POST["timeTrans2"]) && 
                        !empty($_POST["guestnumber2"]) 
                    ){
                        $sql500 = "SELECT `id`, `title`, `price1`, `price2`, `kmlimit` FROM `pages` WHERE `id`='".(int)$_POST['TransporDropDownId2']."' AND `deleted`=0 AND `language`='".$_POST["input_lang"]."'";
                        $fetch500 = db_fetch($sql500);

                        $transport_name2 = $fetch500["title"];

                        $startplace2 = $_POST["startplace2"];
                        $endplace2 = $_POST["endplace2"];
                        $sql4 = "SELECT `price_plus` FROM `catalogs` WHERE `id`='".(int)$_POST["startplace2"]."' AND `language`='".$_POST["input_lang"]."' AND `deleted`=0 AND `visibility`=1";
                        $fetch4 = db_fetch($sql4);

                        $sql5 = "SELECT `price_plus` FROM `catalogs` WHERE `id`='".(int)$_POST["endplace2"]."' AND `language`='".$_POST["input_lang"]."' AND `deleted`=0 AND `visibility`=1";
                        $fetch5 = db_fetch($sql5);

                        $kmDouble = (float)$_POST['km2'];
                        $transport_price_per_km2 = 0;

                        $totalCrow2 = (int)$_POST["guestnumber2"] + (int)$children2 + (int)$underchildren2;
                        if($kmDouble >= $fetch500['kmlimit']){// 200 + კილომეტრი
                            if($totalCrow2<=3 && $fetch500['id']==125){// თუ სტუმ. რაოდ <=3 და სედანია არჩეული
                                $transport_price_per_km2 = (float)$fetch500['price1'];
                            }else if($totalCrow2>3 && $fetch500['id']==125){// თუ სტუმრების რაოდენობა > 3 და არჩეულია სედანი
                                $howManyCars = ceil($totalCrow2 / 3);
                                $transport_price_per_km2 = (float)$fetch500['price1'] * $howManyCars;
                            }else if($totalCrow2<=6 && $fetch500['id']==126){// თუ სტუმ. რაოდ <=6 და მინივენია არჩეული
                                $transport_price_per_km2 = (float)$fetch500['price1'];
                            }else if($totalCrow2>=6 && $fetch500['id']==126){// თუ სტუმრების რაოდენობა > 6 და არჩეულია მინივენი
                                $howManyMinivan = ceil($totalCrow2 / 6);
                                $transport_price_per_km2 = (float)$fetch500['price1'] * $howManyMinivan;
                            }else if($totalCrow2<=12 && $fetch500['id']==127){// თუ სტუმ. რაოდ <=12 და ავტობუსია არჩეული
                                $transport_price_per_km2 = (float)$fetch500['price1'];
                            }else if($totalCrow2>=12 && $fetch500['id']==127){// თუ სტუმრების რაოდენობა > 12 და არჩეულია ავტობუსი
                                $howManyBus = ceil($totalCrow2 / 12);
                                $transport_price_per_km2 = (float)$fetch500['price1'] * $howManyBus;
                            }                       
                        }else{// 200 კილომეტრამდე
                            if($totalCrow2<=3 && $fetch500['id']==125){// თუ სტუმ. რაოდ <=3 და სედანია არჩეული
                                $transport_price_per_km2 = (float)$fetch500['price2'];
                            }else if($totalCrow2>3 && $fetch500['id']==125){// თუ სტუმრების რაოდენობა > 3 და არჩეულია სედანი
                                $howManyCars = ceil($totalCrow2 / 3);
                                $transport_price_per_km2 = (float)$fetch500['price2'] * $howManyCars;
                            }else if($totalCrow2<=6 && $fetch500['id']==126){// თუ სტუმ. რაოდ <=6 და მინივენია არჩეული
                                $transport_price_per_km2 = (float)$fetch500['price2'];
                            }else if($totalCrow2>=6 && $fetch500['id']==126){// თუ სტუმრების რაოდენობა > 6 და არჩეულია მინივენი
                                $howManyMinivan = ceil($totalCrow2 / 6);
                                $transport_price_per_km2 = (float)$fetch500['price2'] * $howManyMinivan;
                            }else if($totalCrow2<=12 && $fetch500['id']==127){// თუ სტუმ. რაოდ <=12 და ავტობუსია არჩეული
                                $transport_price_per_km2 = (float)$fetch500['price2'];
                            }else if($totalCrow2>=12 && $fetch500['id']==127){// თუ სტუმრების რაოდენობა > 12 და არჩეულია ავტობუსი
                                $howManyBus = ceil($totalCrow2 / 12);
                                $transport_price_per_km2 = (float)$fetch500['price2'] * $howManyBus;
                            }
                        }                  


                        $ten4 = ($fetch4['price_plus']==1) ? 10 : 0;
                        $ten5 = ($fetch5['price_plus']==1) ? 10 : 0;
                        $tenBoth2 = $ten4 + $ten5;

                        // $child_price2 = 0;
                        // if(isset($_POST['children2']) && is_numeric($_POST['children2'])){
                        //     for($i = 0; $i < $_POST['children2']; $i++){
                        //         $child_price2 += ceil((float)(($kmDouble*$transport_price_per_km2) / $_POST["guestnumber2"]) / 2);
                        //     }
                        // }

                        $roud2_price = number_format((float)($kmDouble*$transport_price_per_km2), 2, ".", "") + $tenBoth2;
                        $totalprice += $roud2_price;
                    }
                    /* double way end */
                    

                    if(isset($_SESSION["trip_user"])){
                        $userid = $_SESSION["trip_user"];
                    }else{
                        if(isset($_SESSION["cartsession"]))
                        {
                            $userid = $_SESSION["cartsession"];
                        }else{
                            $_SESSION["cartsession"] = g_random(15);
                            $userid = $_SESSION["cartsession"];
                        }
                    }

                    $g_insuarance_damzgvevi = (isset($_POST["g_insuarance_damzgvevi"])) ? $_POST["g_insuarance_damzgvevi"] : ' ';
                    $g_insuarance_dazgveuli = (isset($_POST["g_insuarance_dazgveuli"])) ? $_POST["g_insuarance_dazgveuli"] : ' ';
                    $g_insuarance_misamarti = (isset($_POST["g_insuarance_misamarti"])) ? $_POST["g_insuarance_misamarti"] : ' ';
                    $g_insuarance_dabtarigi = (isset($_POST["g_insuarance_dabtarigi"])) ? $_POST["g_insuarance_dabtarigi"] : ' ';
                    $g_insuarance_pasporti = (isset($_POST["g_insuarance_pasporti"])) ? $_POST["g_insuarance_pasporti"] : ' ';
                    $g_insuarance_piradinomeri = (isset($_POST["g_insuarance_piradinomeri"])) ? $_POST["g_insuarance_piradinomeri"] : ' ';
                    $g_insuarance_telefonis = (isset($_POST["g_insuarance_telefonis"])) ? $_POST["g_insuarance_telefonis"] : ' ';

                    $sqlCart = "INSERT INTO `cart` SET 
                    `date`='".time()."',
                    `pid`='0', 
                    `userid`='{$userid}', 
                    `type`='transport', 
                    `startdate`='{$_POST["startdatetrans"]}', 
                    `timetrans`='{$_POST["timeTrans"]}', 
                    `startplace`='{$_POST["startplace"]}', 
                    `endplace`='{$_POST["endplace"]}', 
                    `guests`='{$_POST["guestnumber"]}', 
                    `children`='{$children}', 
                    `childrenunder`='{$underchildren}', 
                    `double`='0', 
                    `startdate2`='{$_POST["startdatetrans2"]}', 
                    `timetrans2`='{$_POST["timeTrans2"]}', 
                    `startplace2`='{$_POST["startplace2"]}', 
                    `endplace2`='{$_POST["endplace2"]}', 
                    `guests2`='{$_POST["guestnumber2"]}', 
                    `children2`='{$children2}', 
                    `childrenunder2`='{$underchildren2}', 
                    `totalprice`='{$totalprice}',
                    `roud1_price`='{$roud1_price}',
                    `roud2_price`='{$roud2_price}',
                    `transport_name1`='{$transport_name1}',
                    `transport_name2`='{$transport_name2}',
                    `damzgvevi`='{$g_insuarance_damzgvevi}',
                    `dazgveuli`='{$g_insuarance_dazgveuli}', 
                    `misamarti`='{$g_insuarance_misamarti}',
                    `dabtarigi`='{$g_insuarance_dabtarigi}',
                    `pasporti`='{$g_insuarance_pasporti}',
                    `piradinomeri`='{$g_insuarance_piradinomeri}',
                    `telefonis`='{$g_insuarance_telefonis}' 
                    ";

                    /*
                    , 
                    */

                    db_query($sqlCart);

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }

                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            case 'loadmoreSights':
                $Html = "";
                $NewLimit = "";
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["loadedLimit"]) || 
                    !is_numeric($_POST["loadedLimit"])
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    $successText = "";    
                    $Html = "";              
                    $NewLimit = 4;              
                }else{
                    // Do whatever you want to do
                    $NewLimit = $_POST["loadedLimit"] + 4;
                    // $g_sights_list = g_sights_list($_POST["loadedLimit"], 4);
                    $limits = "LIMIT ".$_POST["loadedLimit"].", 4";
                    $g_sights_list = g_places(false, false, "`title` ASC", $limits);
                    
                    foreach ($g_sights_list as $sight):
                        $link = href(141, array(), l(), $sight['id']);
                        $Html .= "<div class=\"col-sm-6\">";
                        $Html .= sprintf(
                            "<a href=\"%s\" class=\"Item\">",
                            $link
                        );
                        $Html .= sprintf(
                            "<div class=\"Background\" style=\"background:url('%s');\"></div>",
                            $sight['image1']
                        );
                        $Html .= sprintf(
                            "<div class=\"Title\">%s</div>",
                            $sight['title']
                        );
                        $Html .= "</a>";
                        $Html .= "</div>";
                    endforeach;

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }

                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Html"=>$Html,
                        "NewLimit"=>$NewLimit,
                        "Details"=>""
                    )
                );
                break;
            case 'mapClicked':
                $Html = "";
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["map_id"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    $successText = "";                
                    $countCartitem = 0;  
                    $Html = "";              
                }else{
                    $map_id = (isset($_POST["map_id"])) ? $_POST["map_id"] : 0;
                    switch ($map_id) {
                        case 1:
                            $map_id = 101;
                            break;
                        case 2:
                            $map_id = 92;
                            break;
                        case 3:
                            $map_id = 98;
                            break;
                        case 4:
                            $map_id = 90;
                            break;
                        case 5:
                            $map_id = 100;
                            break;
                        case 6:
                            $map_id = 94;
                            break;
                        case 7:
                            $map_id = 93;
                            break;
                        case 8:
                            $map_id = 97;
                            break;
                        case 11:
                            $map_id = 96;
                            break;
                        case 9:
                            $map_id = 95;
                            break;
                        case 10:
                            $map_id = 99;
                            break;
                        case 12:
                            $map_id = 91;
                            break;
                    }

                    $sql = "SELECT 
                    (
                        SELECT 
                        COUNT(`catalogs`.`id`)
                        FROM 
                        `catalogs`
                        WHERE 
                        FIND_IN_SET(`pages`.`id`, `catalogs`.`regions`) AND 
                        FIND_IN_SET('105', `catalogs`.`categories`) AND 
                        `catalogs`.`menuid`=24 AND 
                        `catalogs`.`language`='".$_POST["input_lang"]."' AND 
                        `catalogs`.`visibility`=1 AND 
                        `catalogs`.`deleted`=0
                    ) AS sights_counted,
                    (
                        SELECT 
                        COUNT(`catalogs`.`id`)
                        FROM 
                        `catalogs`
                        WHERE 
                        FIND_IN_SET(`pages`.`id`, `catalogs`.`regions`) AND 
                        FIND_IN_SET('106', `catalogs`.`categories`) AND 
                        `catalogs`.`menuid`=24 AND 
                        `catalogs`.`language`='".$_POST["input_lang"]."' AND 
                        `catalogs`.`visibility`=1 AND 
                        `catalogs`.`deleted`=0
                    ) AS wine_counted, 
                    (
                        SELECT 
                        COUNT(`catalogs`.`id`)
                        FROM 
                        `catalogs`
                        WHERE 
                        FIND_IN_SET(`pages`.`id`, `catalogs`.`regions`) AND 
                        FIND_IN_SET('107', `catalogs`.`categories`) AND 
                        `catalogs`.`menuid`=24 AND 
                        `catalogs`.`language`='".$_POST["input_lang"]."' AND 
                        `catalogs`.`visibility`=1 AND 
                        `catalogs`.`deleted`=0
                    ) AS natural_counted, 
                    (
                        SELECT 
                        COUNT(`catalogs`.`id`)
                        FROM 
                        `catalogs`
                        WHERE 
                        FIND_IN_SET(`pages`.`id`, `catalogs`.`regions`) AND 
                        FIND_IN_SET('108', `catalogs`.`categories`) AND 
                        `catalogs`.`menuid`=24 AND 
                        `catalogs`.`language`='".$_POST["input_lang"]."' AND 
                        `catalogs`.`visibility`=1 AND 
                        `catalogs`.`deleted`=0
                    ) AS museum_counted, 
                    `pages`.* 
                    FROM 
                    `pages` 
                    WHERE 
                    `pages`.`id`='".(int)$map_id."' AND 
                    `pages`.`menuid`=27 AND 
                    `pages`.`language`='".$_POST["input_lang"]."'";
                    $fetch = db_fetch($sql);
                    $title = (isset($fetch['title'])) ? $fetch['title'] : '';
                    
                    $sights_counted = (isset($fetch['sights_counted'])) ? $fetch['sights_counted'] : 0;
                    $wine_counted = (isset($fetch['wine_counted'])) ? $fetch['wine_counted'] : 0;
                    $natural_counted = (isset($fetch['natural_counted'])) ? $fetch['natural_counted'] : 0;
                    $museum_counted = (isset($fetch['museum_counted'])) ? $fetch['museum_counted'] : 0;
                    $description = (isset($fetch['description'])) ? $fetch['description'] : '';

                    $Html .= "<div class=\"MapInfoModal\">";
                    $Html .= "<div class=\"InfoHeader\" style=\"background:url('_website/img/modal_bg.png');\">";
                    $Html .= sprintf(
                        "<div class=\"Title\">%s</div>", 
                        $title
                    );
                    $Html .= "</div>";
                    $Html .= "<ul class=\"CatInfoButtons\">";
                    $Html .= sprintf("<li class=\"active\"><a data-toggle=\"tab\" href=\"#CategoriesLink\">%s</a></li>", l("categories"));
                    $Html .= sprintf("<li><a data-toggle=\"tab\" href=\"#InformationLink\">%s</a></li>", l("information"));
                    $Html .= "</ul>";

                    $Html .= "<div class=\"tab-content\">";
                    
                    $Html .= "<div id=\"CategoriesLink\" class=\"tab-pane fade in active\">";
                    $Html .= "<div class=\"MapCategoryDiv\">";
                    
                    $Html .= "<div class=\"col-sm-3\">";
                    $Html .= sprintf(
                        "<a href=\"/%s/ongoing-tours/?page=1&pri=0&cat=108&reg=%s\" class=\"Item\">",
                        $_POST["input_lang"],
                        $fetch['id']
                    );
                    $Html .= "<div class=\"MuseumIcon\"></div>";
                    $Html .= sprintf("<div class=\"Title\" title=\"%s\">%s</div>", l("museums"), g_cut(l("museums"), 11));
                    $Html .= sprintf("<div class=\"Count\">%s</div>", $museum_counted);
                    $Html .= "</a>";
                    $Html .= "</div>";

                    $Html .= "<div class=\"col-sm-3\">";
                    $Html .= sprintf(
                        "<a href=\"/%s/ongoing-tours/?page=1&pri=0&cat=107&reg=%s\" class=\"Item\">",
                        $_POST["input_lang"],
                        $fetch['id']
                    );
                    $Html .= "<div class=\"NaturalIcon\"></div>";
                    $Html .= sprintf("<div class=\"Title\" title=\"%s\">%s</div>", l("naturalsights"), g_cut(l("naturalsights"), 11));
                    $Html .= sprintf("<div class=\"Count\">%s</div>", $natural_counted);
                    $Html .= "</a>";
                    $Html .= "</div>";

                    $Html .= "<div class=\"col-sm-3\">";
                    $Html .= sprintf(
                        "<a href=\"/%s/ongoing-tours/?page=1&pri=0&cat=105&reg=%s\" class=\"Item\">",
                        $_POST["input_lang"],
                        $fetch['id']
                    );
                    $Html .= "<div class=\"CulturalIcon\"></div>";
                    $Html .= sprintf("<div class=\"Title\" title=\"%s\">%s</div>", l("culturalsights"), g_cut(l("culturalsights"), 11));
                    $Html .= sprintf("<div class=\"Count\">%s</div>", $sights_counted);
                    $Html .= "</a>";
                    $Html .= "</div>";

                    $Html .= "<div class=\"col-sm-3\">";
                    $Html .= sprintf(
                        "<a href=\"/%s/ongoing-tours/?page=1&pri=0&cat=106&reg=%s\" class=\"Item\">",
                        $_POST["input_lang"],
                        $fetch['id']
                    );
                    $Html .= "<div class=\"WineToursIcon\"></div>";
                    $Html .= sprintf("<div class=\"Title\" title=\"%s\">%s</div>", l("winetours"), g_cut(l("winetours"), 11));
                    $Html .= sprintf("<div class=\"Count\">%s</div>", $wine_counted);
                    $Html .= "</a>";
                    $Html .= "</div>";
                    $Html .= "</div>";

                    $Html .= "</div>";

                    $Html .= "<div id=\"InformationLink\" class=\"tab-pane fade\">";
                    $Html .= "<div class=\"MapInformationDiv\">";
                    $Html .= "<div class=\"Description\">";
                    $Html .= strip_tags($description, "<p><br><strong><a>");

                    $Html .= "</div>";

                    $Html .= "<div class=\"row\">";
                    $Html .= "<div class=\"InformationList\">";
                    
                    $sights = db_fetch_all("SELECT `id`, `title`, `image1` FROM `catalogs` WHERE FIND_IN_SET('{$fetch['id']}', `regions`) AND `language`='".l()."' AND `menuid`=36 AND `visibility`=1 AND `deleted`=0 ORDER BY `position` ASC");
                    // $Html .= print_r($files, true); 

                    foreach($sights as $sight):
                        $link = href(141, array(), l(), $sight['id']);
                        if(isset($sight['image1']) && !empty($sight['image1'])):
                        $Html .= "<div class=\"col-sm-4\">";
                        //
                        $Html .= sprintf(
                            "<a href=\"%s\" class=\"Item\">",
                            $link
                        );
                        $Html .= "<div class=\"Image\">";
                        $Html .= sprintf(
                            "<div class=\"Background\" style=\"background:url('%s');\"></div>",
                            $sight['image1']
                        );
                        $Html .= "</div>";
                        $Html .= sprintf("<div class=\"Title\" title=\"%s\">%s</div>", $sight['title'], g_cut($sight['title'], 20));
                        $Html .= "</a>";
                        $Html .= "</div>";
                        endif;
                    endforeach;

                    $Html .= "</div>";
                    $Html .= "</div>";
                    $Html .= "</div>";

                    $Html .= "</div>";
                    $Html .= "</div>";
                    $Html .= "</div>";


                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }
                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Html"=>$Html,
                        "Details"=>""
                    )
                );
                break;
            case 'addTripPlanToCart':
                if(
                    empty($_POST["input_lang"]) ||                     
                    empty($_POST["insurance123"])                    
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    $successText = "";                
                    $countCartitem = 0;                
                }else if(empty($_POST["places"]) || empty($_POST["tkn"])){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("atleastoneplace");
                    $successText = "";                
                    $countCartitem = 0; 
                }else if(empty($_POST["startDatePicker"]) || empty($_POST["endDatePicker"])){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("datepickerisempty");
                    $successText = "";                
                    $countCartitem = 0; 
                }else if(empty($_POST["guests"]) || !is_numeric($_POST["guests"]) || $_POST["guests"]<=0){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("atleastoneadult");
                    $successText = "";                
                    $countCartitem = 0;
                }else if(empty($_POST["transport"])){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("transportnotchosen");
                    $successText = "";                
                    $countCartitem = 0;
                }else if(
                    $_POST['insurance123']==1 && 
                    (
                        empty($_POST["g_insuarance_damzgvevi"]) || 
                        empty($_POST["g_insuarance_dazgveuli"]) || 
                        empty($_POST["g_insuarance_misamarti"]) || 
                        empty($_POST["g_insuarance_dabtarigi"]) || 
                        empty($_POST["g_insuarance_pasporti"]) || 
                        empty($_POST["g_insuarance_piradinomeri"]) || 
                        empty($_POST["g_insuarance_telefonis"]) 
                    )
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("fillinsuredata");
                    $successText = "";                
                    $countCartitem = 0;
                }else{
                    if(isset($_SESSION["trip_user"])){
                        $userid = $_SESSION["trip_user"];
                    }else{
                        if(isset($_SESSION["cartsession"]))
                        {
                            $userid = $_SESSION["cartsession"];
                        }else{
                            $_SESSION["cartsession"] = g_random(15);
                            $userid = $_SESSION["cartsession"];
                        }
                    }

                    $selectTransport = "SELECT `price1`, `price2`, `kmlimit` FROM `pages` WHERE `id`='".(int)$_POST['transport']."' AND `deleted`=0 AND `language`='".l()."'";
                    $transportP = db_fetch($selectTransport);

                    //Count Total price START
                    $totalKm = (float)$_POST['tkn'];
                    $totalprice = 0;
                    $kmprice = 0;
                    $totalCrow = (int)$_POST["guests"] + (int)$_POST["children"] + (int)$_POST["childrenunder"];
                    if($_POST["transport"]==125 && $totalKm<$transportP["kmlimit"]){
                        $kmprice = (float)$transportP["price2"];
                        if($totalCrow >3){
                            $howManyCars = ceil($totalCrow / 3);
                            $kmprice = $kmprice * $howManyCars;
                        }
                    }else if($_POST["transport"]==125 && $totalKm>=$transportP["kmlimit"]){
                        $kmprice = (float)$transportP["price1"]; 
                        if($totalCrow>3){
                            $howManyCars = ceil($totalCrow / 3);
                            $kmprice = $kmprice * $howManyCars;
                        }
                    }else if($_POST["transport"]==126 && $totalKm<$transportP["kmlimit"]){
                        $kmprice = (float)$transportP["price2"]; 
                        if($totalCrow>6){
                            $howManyMinivan = ceil($totalCrow / 6);
                            $kmprice = $kmprice * $howManyMinivan;
                        }
                    }else if($_POST["transport"]==126 && $totalKm>=$transportP["kmlimit"]){
                        $kmprice = (float)$transportP["price1"]; 
                        if($totalCrow>6){
                            $howManyMinivan = ceil($totalCrow / 6);
                            $kmprice = $kmprice * $howManyMinivan;
                        }
                    }else if($_POST["transport"]==127 && $totalKm<$transportP["kmlimit"]){
                        $kmprice = (float)$transportP["price2"]; 
                        if($totalCrow>12){
                            $howManyBus = ceil($totalCrow / 12);
                            $kmprice = $kmprice * $howManyBus;
                        }
                    }else if($_POST["transport"]==127 && $totalKm>=$transportP["kmlimit"]){
                        $kmprice = (float)$transportP["price1"]; 
                        if($totalCrow>12){
                            $howManyBus = ceil($totalCrow / 12);
                            $kmprice = $kmprice * $howManyBus;
                        }
                    }

                    // $child_price_ = 0;

                    // if(isset($_POST["children"]) && is_numeric($_POST["children"]) && $_POST["children"]>0){
                    //     for($i = 0; $i < $_POST["children"]; $i++){
                    //         $child_price_ += $totalKm * $kmprice / $_POST["guests"] / 2;
                    //     }
                    // }

                    $children = (isset($_POST["children"]) && is_numeric($_POST["children"])) ? $_POST["children"] : 0;
                    $childrenunder = (isset($_POST["childrenunder"]) && is_numeric($_POST["childrenunder"])) ? $_POST["childrenunder"] : 0;

                    $totalprice = (float)($totalKm * $kmprice); // + child_price_
                    $totalprice = number_format($totalprice, 2, '.', '');
                    //Count Total price end
                    
                    

                    $g_insuarance_damzgvevi = (isset($_POST["g_insuarance_damzgvevi"])) ? $_POST["g_insuarance_damzgvevi"] : ' ';
                    $g_insuarance_dazgveuli = (isset($_POST["g_insuarance_dazgveuli"])) ? $_POST["g_insuarance_dazgveuli"] : ' ';
                    $g_insuarance_misamarti = (isset($_POST["g_insuarance_misamarti"])) ? $_POST["g_insuarance_misamarti"] : ' ';
                    $g_insuarance_dabtarigi = (isset($_POST["g_insuarance_dabtarigi"])) ? $_POST["g_insuarance_dabtarigi"] : ' ';
                    $g_insuarance_pasporti = (isset($_POST["g_insuarance_pasporti"])) ? $_POST["g_insuarance_pasporti"] : ' ';
                    $g_insuarance_piradinomeri = (isset($_POST["g_insuarance_piradinomeri"])) ? $_POST["g_insuarance_piradinomeri"] : ' ';
                    $g_insuarance_telefonis = (isset($_POST["g_insuarance_telefonis"])) ? $_POST["g_insuarance_telefonis"] : ' ';


                    $hotel = (isset($_POST["hotel"])) ? $_POST["hotel"] : 0;
                    $hotelPrice = "SELECT `menutitle` FROM `pages` WHERE `id`=".$hotel." AND `language`='".l()."' AND `deleted`=0";
                    $fetchHotelPrice = db_fetch($hotelPrice);
                    if(isset($fetchHotelPrice["menutitle"])){
                        $totalprice += (int)$fetchHotelPrice["menutitle"] * (int)$_POST["guests"];
                    }

                    $cuisune = (isset($_POST["cuisune"])) ? json_decode($_POST["cuisune"], true) : array();
                    $cuisuneInsert = array();
                    foreach ($cuisune as $v) {
                        $cuisuneId = $v["cuisuneId"];
                        $people = $v["people"];
                        $cuisuneInsert[] = "[".$people.":".$cuisuneId."]";
                        $cuisunePrice = "SELECT `menutitle` FROM `pages` WHERE `id`=".$cuisuneId." AND `language`='".l()."' AND `deleted`=0";
                        $fetchCuisunePrice = db_fetch($cuisunePrice);
                        if(isset($fetchCuisunePrice["menutitle"])){
                            $totalprice += (int)$fetchCuisunePrice["menutitle"] * (int)$people;
                        }
                    }                    

                    $guide = (isset($_POST["guide"])) ? $_POST["guide"] : 0;
                    $guidePrice = "SELECT `menutitle` FROM `pages` WHERE `id`=".$guide." AND `language`='".l()."' AND `deleted`=0";
                    $fetchGuidePrice = db_fetch($guidePrice);
                    if(isset($fetchGuidePrice["menutitle"])){
                        $totalprice += (int)$fetchGuidePrice["menutitle"] * (int)$_POST["guests"];
                    }



                    $transport = (isset($_POST["transport"])) ? $_POST["transport"] : 0;

                    $insert = "INSERT INTO `cart` SET 
                    `date`='".time()."', 
                    `startdate`='{$_POST["startDatePicker"]}', 
                    `startdate2`='{$_POST["endDatePicker"]}', 
                    `startplace`='{$_POST["startPlace"]}', 
                    `guests`='{$_POST["guests"]}', 
                    `children`='{$children}', 
                    `childrenunder`='{$childrenunder}', 
                    `pid`='0', 
                    `userid`='{$userid}', 
                    `sold`=0, 
                    `quantity`=0, 
                    `type`='plantrip', 
                    `totalprice`='{$totalprice}', 
                    `tourplaces`='{$_POST['places']}',
                    `damzgvevi`='{$g_insuarance_damzgvevi}',
                    `dazgveuli`='{$g_insuarance_dazgveuli}', 
                    `misamarti`='{$g_insuarance_misamarti}',
                    `dabtarigi`='{$g_insuarance_dabtarigi}',
                    `pasporti`='{$g_insuarance_pasporti}',
                    `piradinomeri`='{$g_insuarance_piradinomeri}',
                    `telefonis`='{$g_insuarance_telefonis}',
                    `hotels`='{$hotel}',
                    `cuisune`='".implode(',',$cuisuneInsert)."',
                    `guide`='{$guide}',
                    `transport_name1`='{$transport}'
                    ";
                    db_query($insert);
                   
                    $countCartitem = g_cart_count($userid);

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }

                $out = array(
                    "Error" => array( 
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>"",
                        "countCartitem"=>$countCartitem
                    )
                );
                break;
            case 'changeCurrency':
                if(
                    empty($_POST["cur"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    $successText = "";                 
                    $successCurr = "GEL";                 
                }else{
                    $_SESSION["currency"] = $_POST["cur"]; 


                    $successCurr = strtoupper($_POST["cur"]); 
                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }

                $out = array(
                    "Error" => array( 
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Currency"=>$successCurr,
                        "Details"=>""
                    )
                );
                break;
            case 'removeCartItem':
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["id"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    $successText = "";                
                    $countCartitem = 0;                
                }else{
                    if(isset($_SESSION["trip_user"])){
                        $userid = $_SESSION["trip_user"];
                    }else{
                        if(isset($_SESSION["cartsession"]))
                        {
                            $userid = $_SESSION["cartsession"];
                        }else{
                            $userid = 0;
                        }
                    }

                    db_query("DELETE FROM `cart` WHERE `id`='".(int)$_POST["id"]."' AND `userid`='".$userid."'"); 
                    
                    $countCartitem = g_cart_count($userid);

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }
                $out = array(
                    "Error" => array( 
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>"",
                        "countCartitem"=>$countCartitem
                    )
                );
                break;
            case 'updateCart':
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["id"]) || 
                    empty($_POST["insurance123"]) || 
                    empty($_POST["guestNuber"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    $successText = "";
                    $updateType = "";
                    $countCartitem = 0;
                }else if(
                    $_POST['insurance123']==1 && 
                    (
                        empty($_POST["g_insuarance_damzgvevi"]) || 
                        empty($_POST["g_insuarance_dazgveuli"]) || 
                        empty($_POST["g_insuarance_misamarti"]) || 
                        empty($_POST["g_insuarance_dabtarigi"]) || 
                        empty($_POST["g_insuarance_pasporti"]) || 
                        empty($_POST["g_insuarance_piradinomeri"]) || 
                        empty($_POST["g_insuarance_telefonis"]) 
                    )
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("fillinsuredata");
                    $successText = "";                
                    $countCartitem = 0;
                    $updateType = "";
                    $countCartitem = 0;
                }else{
                    $children = (isset($_POST["children"])) ? $_POST['children'] : 0;
                    if(isset($_SESSION["trip_user"])){
                        $userid = $_SESSION["trip_user"];
                    }else{
                        if(isset($_SESSION["cartsession"]))
                        {
                            $userid = $_SESSION["cartsession"];
                        }else{
                            $_SESSION["cartsession"] = g_random(15);
                            $userid = $_SESSION["cartsession"];
                        }
                    }

                    $g_insuarance_damzgvevi = (isset($_POST["g_insuarance_damzgvevi"])) ? $_POST["g_insuarance_damzgvevi"] : ' ';
                    $g_insuarance_dazgveuli = (isset($_POST["g_insuarance_dazgveuli"])) ? $_POST["g_insuarance_dazgveuli"] : ' ';
                    $g_insuarance_misamarti = (isset($_POST["g_insuarance_misamarti"])) ? $_POST["g_insuarance_misamarti"] : ' ';
                    $g_insuarance_dabtarigi = (isset($_POST["g_insuarance_dabtarigi"])) ? $_POST["g_insuarance_dabtarigi"] : ' ';
                    $g_insuarance_pasporti = (isset($_POST["g_insuarance_pasporti"])) ? $_POST["g_insuarance_pasporti"] : ' ';
                    $g_insuarance_piradinomeri = (isset($_POST["g_insuarance_piradinomeri"])) ? $_POST["g_insuarance_piradinomeri"] : ' ';
                    $g_insuarance_telefonis = (isset($_POST["g_insuarance_telefonis"])) ? $_POST["g_insuarance_telefonis"] : ' ';

                    $select = "SELECT `id` FROM `cart` WHERE `pid`='".(int)$_POST["id"]."' AND `type`='ongoing' AND `userid`='".$userid."'";
                    $fetch = db_fetch($select);

                    if(isset($fetch['id'])){
                        db_query("DELETE FROM `cart` WHERE `pid`='".(int)$_POST["id"]."' AND `type`='ongoing' AND `userid`='".$userid."'");
                        $updateType = "removed";
                    }else{
                        $selectProduct = "SELECT `guest_sedan`, `price_sedan`, `price_minivan`, `price_bus`, `tour_margin`, `cuisune_price1person`, `ticketsandother_price1person` FROM `catalogs` WHERE `id`='".(int)$_POST["id"]."' AND `language`='".l()."' AND `deleted`=0 AND `visibility`=1";
                        $fetchProduct = db_fetch($selectProduct);
                        
                        $totalprice = 0;
                        $crew = (int)$_POST["guestNuber"]; 
                        $totalCrew = (int)$_POST["guestNuber"] + (int)$children + (int)$_POST['childrenunder'];
                        $perprice = 0;
                        if($totalCrew<=3){// sedan
                          $tour_margin = 100 - $fetchProduct['tour_margin'];
                          $bep = ceil(($fetchProduct["price_sedan"] / 100) * $tour_margin); 
                          if($totalCrew<=$fetchProduct["guest_sedan"]){
                            $perprice = $bep / $totalCrew;
                          }else{
                            $perprice = $fetchProduct["price_sedan"] / $totalCrew;
                          }
                        }else if($totalCrew > 3 && $totalCrew <= 6){//mini van
                          $perprice = $fetchProduct["price_minivan"] / $totalCrew;      
                        }else{
                          if($totalCrew<=12){
                            $perprice = $fetchProduct["price_bus"] / $totalCrew;
                          }else{
                            $howManyBus = ceil($totalCrew / 12);
                            $bussesTotalPrice = ceil($fetchProduct["price_bus"] * $howManyBus);
                            $perprice = $bussesTotalPrice / $totalCrew;
                          }
                        }

                        // $child_price = 0;

                        $cuisune_price = $crew * $fetchProduct['cuisune_price1person'];
                        $ticket_price = $crew * $fetchProduct['ticketsandother_price1person'];

                        $cuisune_price_child = 0;
                        $ticket_price_child = 0;
                        for($i = 0; $i < $children; $i++){
                            // $child_price += ceil($perprice / 2);
                            $cuisune_price_child += ceil($fetchProduct['cuisune_price1person'] / 2);
                            $ticket_price_child += ceil($fetchProduct['ticketsandother_price1person'] / 2);
                        }

                        $totalprice = number_format(($perprice * $totalCrew) + $cuisune_price + $ticket_price + $cuisune_price_child + $ticket_price_child, 2, ".", "");

                        $childrenunder = (isset($_POST['childrenunder']) && is_numeric($_POST['childrenunder'])) ? $_POST['childrenunder'] : 0;

                        if(isset($_POST["inside"]) && $_POST["inside"]!="false"){
                            $startdate = strtotime($_POST["inside"]);
                            $startdate = date("Y-m-d", $startdate);
                        }else{
                            $startdate = date("Y-m-d", time()+172800);
                        }           

                        $insert = "INSERT INTO `cart` SET 
                        `date`='".time()."', 
                        `pid`='".(int)$_POST["id"]."', 
                        `userid`='".$userid."', 
                        `guests`='".(int)$_POST["guestNuber"]."', 
                        `children`='".(int)$children."', 
                        `childrenunder`='".(int)$childrenunder."', 
                        `totalprice`='".(float)$totalprice."', 
                        `sold`=0, 
                        `quantity`=0,
                        `damzgvevi`='{$g_insuarance_damzgvevi}',
                        `dazgveuli`='{$g_insuarance_dazgveuli}', 
                        `misamarti`='{$g_insuarance_misamarti}',
                        `dabtarigi`='{$g_insuarance_dabtarigi}',
                        `pasporti`='{$g_insuarance_pasporti}',
                        `piradinomeri`='{$g_insuarance_piradinomeri}',
                        `telefonis`='{$g_insuarance_telefonis}',
                        `startdate`='".$startdate."'
                        ";
                        db_query($insert);
                        $updateType = "inserted";
                    }
                   
                    $countCartitem = g_cart_count($userid);

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }

                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "updateType"=>$updateType,
                        "countCartitem"=>$countCartitem,
                        "Details"=>""
                    )
                );
                break;
            case 'loadcatalog':
                $filter = "";
                $Html = "";
                $out_couned = 0;
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["current_page"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    $successText = "";
                }else{
                    $res = g_ajax_catalog_list_load();
                    $out_couned = (isset($res[0]["counted"])) ? $res[0]["counted"] : 0;
                    if($out_couned>0){
                        foreach ($res as $item): 
                            $link = href(63, array(), l(), $item['id']);
                            $Html .= "<div class=\"col-sm-3\">";
                            $Html .= "<div class=\"Item\">";
                            $Html .= sprintf(
                                "<div class=\"TopInfo\" onclick=\"location.href='%s'\">", 
                                str_replace(array('"',"'"," "),"",$link)
                            );
                            $Html .= sprintf(
                                "<div class=\"Background\" style=\"background:url('%s');\"></div>",
                                $item['image1']
                            );
                            // $Html .= sprintf(
                            //     "<div class=\"UserCount\"><span>%s</span></div>",
                            //     $item['tourists']
                            // );
                            $Html .= "</div>";
                            $Html .= sprintf(
                                "<div class=\"BottomInfo\" onclick=\"location.href='%s'\">",
                                $link
                            );
                            $Html .= sprintf(
                                "<div class=\"Title\">%s</div>",
                                g_cut($item['title'], 40)
                            );
                            $Html .= sprintf(
                                "<div class=\"Day\">%s %s</div>",
                                $item['day_count'],
                                ($item['day_count']<=1) ? l("days") : l("daysm")
                            );
                            // $Html .= sprintf(
                            //     "<div class=\"Price\">Package Price: <span>%s <i>A</i></span></div>",
                            //     $item['price']
                            // );
                            $Html .= "</div>";
                            $Html .= "<div class=\"Buttons\">";
                            $activeCart = (!empty($item['cartId'])) ? ' active' : '';
                            $Html .= sprintf(
                                "<a href=\"javascript:void(0)\" class=\"addCart%s\" data-id=\"%s\" data-title=\"%s\" data-errortext=\"%s\"><span class=\"CartIcon\"></span> %s</a>",
                                $activeCart,
                                $item['id'], 
                                l("message"),
                                l("error"),
                                l("addtocart")
                            );
                            $Html .= sprintf(
                                "<a href=\"%s\">%s</a>",
                                $link,
                                l("more")
                            );
                            $Html .= "</div>";
                            $Html .= "</div>";
                            $Html .= "</div>";
                        
                        endforeach;
                    }
                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }
                $out = array(
                    "Error" => array(
                        "out_couned"=>$out_couned, 
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Html"=>$Html,
                        "Details"=>""
                    )
                );
                break;
            case 'loadmorecatalog':
                $filter = "";
                $Html = "";
                $out_couned = 0;
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["current_page"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    $successText = "";
                }else{
                    $res = g_ajax_catalog_list_load();
                    $out_couned = (isset($res[0]["counted"])) ? $res[0]["counted"] : 0;
                    foreach ($res as $item): 
                        $link = href(63, array(), l(), $item['id']);
                        $Html .= "<div class=\"col-sm-3\">";
                        $Html .= "<div class=\"Item\">";
                        $Html .= sprintf(
                            "<div class=\"TopInfo\" onclick=\"location.href='%s'\">", 
                            str_replace(array('"',"'"," "),"",$link)
                        );
                        $Html .= sprintf(
                            "<div class=\"Background\" style=\"background:url('%s');\"></div>",
                            $item['image1']
                        );
                        // $Html .= "<div class=\"UserCount\"><span>7</span></div>";
                        $Html .= "</div>";
                        $Html .= sprintf(
                            "<div class=\"BottomInfo\" onclick=\"location.href='%s'\">",
                            $link
                        );
                        $Html .= sprintf(
                            "<div class=\"Title\">%s</div>",
                            g_cut($item['title'], 40)
                        );
                        $Html .= sprintf(
                            "<div class=\"Day\">%s %s</div>",
                            $item['day_count'],
                            ($item['day_count']<=1) ? l("days") : l("daysm")
                        );
                        // $Html .= sprintf(
                        //     "<div class=\"Price\">Package Price: <span>%s <i>A</i></span></div>",
                        //     $item['price']
                        // );
                        $Html .= "</div>";
                        $Html .= "<div class=\"Buttons\">";
                        $Html .= sprintf(
                            "<a href=\"javascript:void(0)\" class=\"addCart\" data-inside=\"false\" data-id=\"%s\"><span class=\"CartIcon\"></span> %s</a>",
                            $item['id'],
                            l("addtocart")
                        );
                        $Html .= sprintf(
                            "<a href=\"%s\">%s</a>",
                            $link,
                            l("more")
                        );
                        $Html .= "</div>";
                        $Html .= "</div>";
                        $Html .= "</div>";
                    
                    endforeach;
                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }
                $out = array(
                    "Error" => array(
                        "out_couned"=>$out_couned, 
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Html"=>$Html,
                        "Details"=>""
                    )
                );
                break;
            case 'logintry':
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["login"]) ||                    
                    empty($_POST["password"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    if(empty($_POST["login"]) && !isset($_POST["top"])){
                         $gErrorRedLine[] ="login-email-box";
                    }
                    
                    if(empty($_POST["password"]) && !isset($_POST["top"])){
                         $gErrorRedLine[] = "login-password-box";
                    }

                    if(empty($_POST["login"]) && isset($_POST["top"])){
                         $gErrorRedLine[] ="top-login-email-box";
                    }
                    
                    if(empty($_POST["password"]) && isset($_POST["top"])){
                         $gErrorRedLine[] = "top-login-password-box";
                    }
                    $successText = "";
                }else if(!filter_var($_POST["login"], FILTER_VALIDATE_EMAIL)){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("emailerror");
                    if(!isset($_POST["top"])){
                        $gErrorRedLine = array(
                            "login-email-box"
                        );
                    }else{
                        $gErrorRedLine = array(
                            "top-login-email-box"
                        );
                    }
                    $successText = "";
                }else if(g_user_exists($_POST["login"], $_POST["password"])){
                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $gErrorRedLine = array();
                    $successText = l("welldone");

                    $_SESSION["trip_user"] = $_POST["login"];
                    $_SESSION["trip_user_info"] = g_userinfo();

                    if(isset($_SESSION["cartsession"]))
                    {
                        $userid = $_SESSION["cartsession"];
                        $sql5 = "UPDATE `cart` SET `userid`='".$_POST["login"]."' WHERE `userid`='".$userid."'";
                        db_query($sql5);
                    }
                }else{
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("usernotexists");
                    $gErrorRedLine = array(
                        "popupbox"
                    );
                    $successText = "";
                }

                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "errorFields"=>$gErrorRedLine,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            case 'registernewuser':
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["firstname"]) || 
                    empty($_POST["lastname"]) || 
                    empty($_POST["idnumber"]) || 
                    empty($_POST["birthday"]) || 
                    empty($_POST["mobilenumber"]) || 
                    empty($_POST["email"]) || 
                    empty($_POST["password"]) || 
                    empty($_POST["passwordConfirm"]) || 
                    empty($_POST["capchacode"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    if(empty($_POST["firstname"])){
                         $gErrorRedLine[] ="first-name-box";
                    }
                    if(empty($_POST["lastname"])){
                         $gErrorRedLine[] = "last-name-box";
                    }
                    if(empty($_POST["idnumber"])){
                         $gErrorRedLine[] = "id-number-box";
                    }
                    if(empty($_POST["birthday"])){
                         $gErrorRedLine[] = "birthday-box";
                    }
                    if(empty($_POST["mobilenumber"])){
                         $gErrorRedLine[] = "mobile-number-box";
                    }
                    if(empty($_POST["email"])){
                         $gErrorRedLine[] = "email-address-box";
                    }
                    if(empty($_POST["password"])){
                         $gErrorRedLine[] = "password-box";
                    }
                    if(empty($_POST["passwordConfirm"])){
                         $gErrorRedLine[] = "password-confirm-box";
                    }
                    if(empty($_POST["capchacode"])){
                         $gErrorRedLine[] = "captcha-code-box";
                    }
                    
                    $successText = "";
                }else if($_SESSION["php_captcha"]!=$_POST["capchacode"]){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("error");
                    $gErrorRedLine = array(
                        "captcha-code-box"
                    );
                    $successText = "";
                }else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("emailerror");
                    $gErrorRedLine = array(
                        "email-address-box"
                    );
                    $successText = "";
                }else if(g_user_exists($_POST["email"])){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("userexists");
                    $gErrorRedLine = array(
                        "email-address-box"
                    );
                    $successText = "";
                }
                //else if(!is_numeric($_POST["idnumber"]) || strlen($_POST["idnumber"]) != 11){
                //     $errorCode = 1;
                //     $successCode = 0;
                //     $errorText = l("idnumbererror");
                //     $gErrorRedLine = array(
                //         "id-number-box"
                //     );
                //     $successText = "";
                // }
                else if(strlen($_POST["password"]) <= 4){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("passworderror");
                    $gErrorRedLine = array(
                        "password-box"
                    );
                    $successText = "";
                }else if($_POST["password"]!==$_POST["passwordConfirm"]){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("passwordmatch");
                    $gErrorRedLine = array(
                        "password-box",
                        "password-confirm-box"
                    );
                    $successText = "";
                }else if($_POST["termsCondi"]!="true"){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("pleaseagree");
                    $gErrorRedLine = array(
                        "popupbox"
                    );
                    $successText = "";
                }else{
                    $random_number = rand(50000,100000);

                    $insert = db_insert("site_users", array(
                        'date' => time(),
                        'firstname' => $_POST["firstname"],
                        'lastname' => $_POST["lastname"],
                        'pn' => $_POST["idnumber"],
                        'birthdate' => $_POST["birthday"],
                        'username' => $_POST["email"],
                        'mobile' => $_POST["mobilenumber"],
                        'userpass' => md5($_POST["password"]),
                        'email' => $_POST["email"],
                        'active' => 0,
                        'random' => $random_number,
                        'banned' => 0,
                        'deleted' => 0,
                        'regdate' => date("Y-m-d")
                    ));
                    db_query($insert);

                    $activate_account_link = sprintf(
                        "<a href=\"%s%s/activate-account/?a=%s\">%s</a>", 
                        WEBSITE_BASE, 
                        l(),
                        $random_number, 
                        $random_number 
                    );

                    $email_text = sprintf(
                      l("registrationemailtext"), 
                      "<strong>Trip Planner</strong>",
                      $activate_account_link
                    );

                    g_send_email(array(
                      "sendTo"=>$_POST["email"], 
                      "subject"=>"Registration", 
                      "body"=>$email_text 
                    ));

                    $_SESSION["trip_user"] = $_POST["email"];
                    $_SESSION["trip_user_info"] = g_userinfo($_POST["email"]);

                    if(isset($_SESSION["cartsession"]))
                    {
                        $userid = $_SESSION["cartsession"];
                        $sql5 = "UPDATE `cart` SET `userid`='".$_POST["login"]."' WHERE `userid`='".$userid."'";
                        db_query($sql5);
                    }

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $gErrorRedLine = array();
                    $successText = l("welldone");
                }
                
                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "errorFields"=>$gErrorRedLine,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );

                break;
            case "recoverStepTwo":
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["email"]) || 
                    empty($_POST["secrite"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    if(empty($_POST["email"])){
                         $gErrorRedLine[] = "forget-email-box";
                    }
                    if(empty($_POST["secrite"])){
                         $gErrorRedLine[] = "forget-secrite-box";
                    }
                    
                    $successText = "";
                }else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("emailerror");
                    $gErrorRedLine = array(
                        "forget-email-box"
                    );
                    $successText = "";
                }else if(g_user_recover($_POST["email"], $_POST["secrite"])){
                    $newPassword = rand(10000000,99999999);

                    $update = "UPDATE `site_users` SET 
                        `userpass`='".md5($newPassword)."'
                        WHERE 
                        `username`='".$_POST["email"]."' AND 
                        `deleted`=0
                    "; 
                    if(db_query($update)){
                        $email_text = sprintf(
                          l("newspassword"), 
                          "<strong>Trip Planner</strong><br />",
                          $newPassword
                        );
                        g_send_email(array(
                          "sendTo"=>$_POST["email"], 
                          "subject"=>l("newpassword"), 
                          "body"=>$email_text 
                        )); 

                        $errorCode = 0;
                        $successCode = 1;
                        $errorText = "";
                        $gErrorRedLine = array(
                            "popupbox"
                        );
                        $successText = l("checkyouremail");  
                    }
                }else{
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("checkfields");
                    $gErrorRedLine = array(
                        "forget-secrite-box"
                    );
                    $successText = ""; 
                }

                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "errorFields"=>$gErrorRedLine,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            case "recoverStepOne":
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["email"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("emailfieldisrequired");
                    if(empty($_POST["email"])){
                         $gErrorRedLine[] = "forget-email-box";
                    }
                    
                    $successText = "";
                }else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("emailerror");
                    $gErrorRedLine = array(
                        "forget-email-box"
                    );
                    $successText = "";
                }else if(g_user_exists($_POST["email"])){
                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $gErrorRedLine = array();
                    $successText = l("checkyouremail");

                    $random = rand(10000,99999);
                    $email_text = sprintf(
                      l("recoverEmailText"), 
                      "<strong>Trip Planner</strong><br />",
                      $random
                    );

                    $update = "UPDATE `site_users` SET 
                        `recover`='".$random."'
                        WHERE 
                        `username`='".$_POST["email"]."' AND 
                        `deleted`=0
                    "; 
                    if(db_query($update)){
                        g_send_email(array(
                          "sendTo"=>$_POST["email"], 
                          "subject"=>l("recover"), 
                          "body"=>$email_text 
                        ));   
                    }
                }else{
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("usernotexists");
                    $gErrorRedLine = array("forget-email-box");
                    $successText = "";
                }

                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "errorFields"=>$gErrorRedLine,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            case "editprofile":
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["firstname"]) || 
                    empty($_POST["lastname"]) || 
                    empty($_POST["idnumber"]) || 
                    empty($_POST["birthday"]) || 
                    empty($_POST["mobilenumber"]) || 
                    empty($_POST["email"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    if(empty($_POST["firstname"])){
                         $gErrorRedLine[] ="profile-first-name-box";
                    }
                    if(empty($_POST["lastname"])){
                         $gErrorRedLine[] = "profile-last-name-box";
                    }
                    if(empty($_POST["idnumber"])){
                         $gErrorRedLine[] = "profile-id-number-box";
                    }
                    if(empty($_POST["birthday"])){
                         $gErrorRedLine[] = "profile-birthday-box";
                    }
                    if(empty($_POST["mobilenumber"])){
                         $gErrorRedLine[] = "profile-mobile-box";
                    }
                    if(empty($_POST["email"])){
                         $gErrorRedLine[] = "profile-email-box";
                    }
                    
                    $successText = "";
                }else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("emailerror");
                    $gErrorRedLine = array(
                        "profile-email-box"
                    );
                    $successText = "";
                }else{
                    $username = (isset($_SESSION["trip_user"])) ? $_SESSION["trip_user"] : "";
                    $update = "UPDATE `site_users` SET 
                        `firstname`='".$_POST["firstname"]."', 
                        `lastname`='".$_POST["lastname"]."', 
                        `pn`='".$_POST["idnumber"]."', 
                        `birthdate`='".$_POST["birthday"]."', 
                        `mobile`='".$_POST["mobilenumber"]."', 
                        `email`='".$_POST["email"]."' 
                        WHERE 
                        `username`='".$username."' AND 
                        `deleted`=0
                    "; 
                    if(db_query($update)){
                        $errorCode = 0;
                        $successCode = 1;
                        $errorText = "";
                        $gErrorRedLine = array("popupbox");
                        $successText = l("welldone");
                        unset($_SESSION["trip_user_info"]); 

                        $_SESSION["trip_user_info"] = g_userinfo();
                    }                    
                }
                
                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "errorFields"=>$gErrorRedLine,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            case "removeProfileImage":
                if(
                    empty($_POST["input_lang"]) || 
                    !isset($_SESSION["trip_user"])
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("error");                    
                    $successText = "";
                }else{
                    $username = (isset($_SESSION["trip_user"])) ? $_SESSION["trip_user"] : "";

                    $update = "UPDATE `site_users` SET                         
                        `picture`='' 
                        WHERE 
                        `username`='".$username."' AND 
                        `deleted`=0
                    "; 
                    db_query($update);

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone"); 

                    $picture = str_replace("https://tripplanner.ge/", "/home3/tripplanner/public_html/_website/", $_SESSION["trip_user_info"]["picture"]);
                    @unlink($picture);
                    $_SESSION["trip_user_info"]["picture"] = "";
                }

                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            case "contactus":
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["firstname"]) || 
                    empty($_POST["lastname"]) || 
                    empty($_POST["mobilenumber"]) || 
                    empty($_POST["email"]) || 
                    empty($_POST["comment"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    if(empty($_POST["firstname"])){
                         $gErrorRedLine[] ="contact-firstname-box";
                    }
                    if(empty($_POST["lastname"])){
                         $gErrorRedLine[] = "contact-lastname-box";
                    }
                    if(empty($_POST["mobilenumber"])){
                         $gErrorRedLine[] = "contact-mobile-box";
                    }
                    if(empty($_POST["email"])){
                         $gErrorRedLine[] = "contact-email-box";
                    }
                    if(empty($_POST["comment"])){
                         $gErrorRedLine[] = "contact-comment-box";
                    }
                    $successText = "";
                }else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("emailerror");
                    $gErrorRedLine = array(
                        "contact-email-box"
                    );
                    $successText = "";
                }else{
                    $body = sprintf("<strong>%s</strong> %s<br />", l("firstname"), $_POST["firstname"]);
                    $body .= sprintf("<strong>%s</strong> %s<br />", l("lastname"), $_POST["lastname"]);
                    $body .= sprintf("<strong>%s</strong> %s<br />", l("email"), $_POST["email"]);
                    $body .= sprintf("<strong>%s</strong> %s<br />", l("mobile"), $_POST["mobilenumber"]);
                    $body .= sprintf("<strong>%s</strong> %s<br />", l("comment"), $_POST["comment"]);
                    

                    $email_text = sprintf(
                      l("registrationemailtext"), 
                      "<strong>Trip Planner</strong>",
                      $body
                    );

                    g_send_email(array(
                      "sendTo"=>$c['contact.email'], 
                      "subject"=>"Contact us", 
                      "body"=>$email_text 
                    ));

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $gErrorRedLine = array("popupbox");
                    $successText = l("welldone");
                }

                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "errorFields"=>$gErrorRedLine,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            case "updatepassword":
                $username = (isset($_SESSION["trip_user"])) ? $_SESSION["trip_user"] : "";
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["currentpassword"]) || 
                    empty($_POST["newpassword"]) || 
                    empty($_POST["comfirmpassword"])
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");
                    if(empty($_POST["currentpassword"])){
                         $gErrorRedLine[] ="profile-currentpassword-box";
                    }
                    if(empty($_POST["newpassword"])){
                         $gErrorRedLine[] = "profile-newpassword-box";
                    }
                    if(empty($_POST["comfirmpassword"])){
                         $gErrorRedLine[] = "profile-comfirmpassword-box";
                    }
                    
                    
                    $successText = "";
                }else if(strlen($_POST["newpassword"]) <= 4){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("passworderror");
                    $gErrorRedLine = array(
                        "profile-newpassword-box"
                    );
                    $successText = "";
                }else if($_POST["newpassword"]!==$_POST["comfirmpassword"]){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("passwordmatch");
                    $gErrorRedLine = array(
                        "profile-newpassword-box",
                        "profile-comfirmpassword-box"
                    );
                    $successText = "";
                }else if(!g_user_exists($username, $_POST["currentpassword"])){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("oldpasswordnotright");
                    $gErrorRedLine = array(
                        "profile-currentpassword-box"
                    );
                    $successText = "";
                }else{
                    
                    $update = "UPDATE `site_users` SET 
                        `userpass`='".md5($_POST["newpassword"])."'
                        WHERE 
                        `username`='".$username."' AND 
                        `deleted`=0
                    "; 
                    if(db_query($update)){
                        $errorCode = 0;
                        $successCode = 1;
                        $errorText = "";
                        $gErrorRedLine = array("popupbox");
                        $successText = l("welldone");
                    }
                }
                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "errorFields"=>$gErrorRedLine,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            case "loadPlaces": 
                $html = "";
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["categoryList"]) || 
                    count(json_decode($_POST["categoryList"], true))<=0 || 
                    empty($_POST["regionList"])
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");                   
                    $successText = "";
                }else{

                    $list = json_decode($_POST["regionList"], true);
                    $regionList = "";
                    if(count($list)){
                        $regionList .= "AND (";
                        foreach ($list as $v) {
                          $regionList .= "FIND_IN_SET({$v}, `regions`) OR ";
                        }
                        $regionList = substr($regionList, 0, -4);
                        $regionList .= ")";
                    }

                    $list2 = json_decode($_POST["categoryList"], true);
                    $categoryList = "";
                    if(count($list2))
                    {
                        $categoryList .= "AND (";
                        foreach ($list2 as $v) {
                          $categoryList .= "FIND_IN_SET({$v}, `categories`) OR ";
                        }
                        $categoryList = substr($categoryList, 0, -4);
                        $categoryList .= ")";
                    }

                    $sql = "SELECT `id`, `title`, `description`, `image1`, `map_coordinates`, `regions`, `categories` FROM `catalogs` WHERE `language`='".l()."' AND `menuid`=36 AND `visibility`=1 AND `deleted`=0  AND `planner_show`=1 AND `startedplace`!=1 AND `map_coordinates`!='' {$categoryList} {$regionList} ORDER BY `position` ASC";  
                    $fetch = db_fetch_all($sql);

                    $g_places_musiams = array();
                    $g_places_naturalSights = array();
                    $g_places_culturalSights = array();
                    $g_places_wine_tours = array();
                    foreach ($fetch as $v) {
                       if($v['categories']==108){
                        $g_places_musiams[] = $v;
                       }if($v['categories']==107){
                        $g_places_naturalSights[] = $v;
                       }else if($v['categories']==105){
                        $g_places_culturalSights[] = $v;
                       }else if($v['categories']==106){
                        $g_places_wine_tours[] = $v;
                       }
                    }

                    if(in_array(108, $list2)){                        
                        $html .= "<div class=\"col-sm-3 gg_musiams\">";
                        $html .= g_planner_checkboxmodules($g_places_musiams);
                        $html .= "</div>";
                    }

                    if(in_array(107, $list2)){                        
                        $html .= "<div class=\"col-sm-3 gg_natural\">";
                        $html .= g_planner_checkboxmodules($g_places_naturalSights);
                        $html .= "</div>";
                    }

                    if(in_array(105, $list2)){                        
                        $html .= "<div class=\"col-sm-3 gg_calture\">";
                        $html .= g_planner_checkboxmodules($g_places_culturalSights);
                        $html .= "</div>";
                    }

                    if(in_array(106, $list2)){                        
                        $html .= "<div class=\"col-sm-3 gg_wine\">";
                        $html .= g_planner_checkboxmodules($g_places_wine_tours);
                        $html .= "</div>";
                    }

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }
                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Regions"=>$html,
                        "Details"=>""
                    )
                );
                break;
            case "invoicePayment":
                if(
                    empty($_POST["input_lang"]) || 
                    !isset($_SESSION["trip_user"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");                   
                    $successText = "";
                }else{
                    $uniq = md5(time()."uniq");
                    $query = db_query("UPDATE `cart` SET `status`='invoiced', `uniq`='{$uniq}' WHERE `status`='unpayed' AND `userid`='".$_SESSION["trip_user"]."' AND `website`='tripplanner'");

                    g_sent_order_mail("invoiced", "unpayed", "red", $uniq);

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }

                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            case "loadPlacesMobile":
                $html = "";
                if(
                    empty($_POST["input_lang"]) || 
                    empty($_POST["categoryList"]) || 
                    count(json_decode($_POST["categoryList"], true))<=0 || 
                    empty($_POST["regionList"])
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("allfields");                   
                    $successText = "";
                }else{
                    $list = explode(",", $_POST["regionList"]);
                    $regionList = "";
                    if(count($list)){
                        $regionList .= "AND (";
                        foreach ($list as $v) {
                          $regionList .= "FIND_IN_SET({$v}, `regions`) OR ";
                        }
                        $regionList = substr($regionList, 0, -4);
                        $regionList .= ")";
                    }

                    $list2 = json_decode($_POST["categoryList"], true);
                    $categoryList = "";
                    if(count($list2))
                    {
                        $categoryList .= "AND (";
                        foreach ($list2 as $v) {
                          $categoryList .= "FIND_IN_SET({$v}, `categories`) OR ";
                        }
                        $categoryList = substr($categoryList, 0, -4);
                        $categoryList .= ")";
                    }

                    $sql = "SELECT `id`, `title`, `description`, `image1`, `map_coordinates`, `regions`, `categories` FROM `catalogs` WHERE `language`='".l()."' AND `menuid`=36 AND `visibility`=1 AND `deleted`=0  AND `planner_show`=1 AND `startedplace`!=1 AND `map_coordinates`!='' {$categoryList} {$regionList} ORDER BY `position` ASC";  
                    $fetch = db_fetch_all($sql);

                    foreach ($fetch as $item):
                    $html .= "<div class=\"Item\">";
                    $html .= sprintf(
                        "<input class=\"TripCheckbox\" type=\"checkbox\" id=\"Chek%d\" data-map=\"%s\" data-categories=\"%s\" data-title=\"%s\" />",
                        $item['id'],
                        $item['map_coordinates'],
                        $item['categories'],
                        htmlentities($item['title'])
                    );
                    $html .= sprintf(
                        "<label class=\"pull-left Text FontNormal\" for=\"Chek%d\">", 
                        $item['id']
                    );
                    $html .= sprintf(
                        "<img src=\"%s\" alt=\"\" />",
                        $item['image1']
                    );
                    $html .= "<div class=\"Info\">";
                    $html .= sprintf(
                        "<div class=\"Title\">%s</div>",
                        $item['title']
                    );
                    $html .= sprintf(
                        "<div class=\"Text\">%s</div>",
                        g_cut($item['description'], 120)
                    );
                    $html .= "</div>";
                    $html .= "</label>";
                    $html .= "</div>";
                    endforeach;

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }
                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Regions"=>$html,
                        "Details"=>""
                    )
                );
                break;
            case "searchkey":
                $html = "";
                if(
                    empty($_POST["input_lang"]) || 
                    strlen($_POST["key"]) < 3
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("error");                   
                    $successText = "";
                }else{
                    $key = str_replace(
                        array(
                            "'",
                            '"',
                            "!",
                            "@",
                            "#",
                            "$",
                            "%",
                            "`",
                            "^",
                            "&",
                            "*",
                            "(",
                            ")",
                            "+",
                            "-"
                        ),
                        '-',
                        $_POST["key"]
                    );

                    

                    $sql = '(SELECT   
                    `catalogs`.`id` AS page_id,  
                    `catalogs`.`title` AS page_title,  
                    `catalogs`.`image1` AS page_image, 
                    `catalogs`.`menuid` AS page_menuid,
                    `catalogs`.`slug` COLLATE utf8_general_ci AS page_slug,
                    (
                        SELECT   
                        COUNT(`catalogs`.`id`)
                        FROM 
                        `catalogs` 
                        WHERE 
                        (
                            `catalogs`.`title` LIKE "%'.$key.'%" OR 
                            `catalogs`.`title`="'.$key.'" OR 
                            MATCH(`catalogs`.`title`) AGAINST("'.$key.'")
                        ) AND 
                        `catalogs`.`menuid`=24 AND 
                        `catalogs`.`language`="'.l().'" AND 
                        `catalogs`.`deleted`=0 AND 
                        `catalogs`.`visibility`=1
                    ) AS page_catalog_count,
                    (
                        SELECT  
                        COUNT(`pages`.`id`)
                        FROM
                        `pages`
                        WHERE 
                        (
                            `pages`.`title` LIKE "%'.$key.'%" OR 
                            `pages`.`title`="'.$key.'" OR 
                            MATCH(`pages`.`title`) AGAINST("'.$key.'")
                        ) AND
                        `pages`.`menuid`=28 AND 
                        `pages`.`language`="'.l().'" AND 
                        `pages`.`deleted`=0 
                    ) AS page_pages_count
                    FROM 
                    `catalogs` 
                    WHERE 
                    (
                        `catalogs`.`title` LIKE "%'.$key.'%" OR 
                        `catalogs`.`title`="'.$key.'" OR 
                        MATCH(`catalogs`.`title`) AGAINST("'.$key.'")
                    ) AND 
                    `catalogs`.`menuid`=24 AND 
                    `catalogs`.`language`="'.l().'" AND 
                    `catalogs`.`deleted`=0 AND 
                    `catalogs`.`visibility`=1) 
                    UNION
                    (
                        SELECT  
                        `pages`.`id` AS page_id, 
                        `pages`.`title` AS page_title, 
                        `pages`.`image1` AS page_image,
                        `pages`.`menuid` AS page_menuid,
                        `pages`.`slug` COLLATE utf8_general_ci AS page_slug,
                        (
                            SELECT   
                            COUNT(`catalogs`.`id`)
                            FROM 
                            `catalogs` 
                            WHERE 
                            (
                                `catalogs`.`title` LIKE "%'.$key.'%" OR 
                                `catalogs`.`title`="'.$key.'" OR 
                                MATCH(`catalogs`.`title`) AGAINST("'.$key.'")
                            ) AND 
                            `catalogs`.`menuid`=24 AND 
                            `catalogs`.`language`="'.l().'" AND 
                            `catalogs`.`deleted`=0 AND 
                            `catalogs`.`visibility`=1
                        ) AS page_catalog_count,
                        (
                            SELECT  
                            COUNT(`pages`.`id`)
                            FROM
                            `pages`
                            WHERE 
                            (
                                `pages`.`title` LIKE "%'.$key.'%" OR 
                                `pages`.`title`="'.$key.'" OR 
                                MATCH(`pages`.`title`) AGAINST("'.$key.'")
                            ) AND
                            `pages`.`menuid`=28 AND 
                            `pages`.`language`="'.l().'" AND 
                            `pages`.`deleted`=0 
                        ) AS page_pages_count
                        FROM
                        `pages`
                        WHERE 
                        (
                            `pages`.`title` LIKE "%'.$key.'%" OR 
                            `pages`.`title`="'.$key.'" OR 
                            MATCH(`pages`.`title`) AGAINST("'.$key.'")
                        ) AND
                        `pages`.`menuid`=28 AND 
                        `pages`.`language`="'.l().'" AND 
                        `pages`.`deleted`=0 
                    )
                    ';
                    $fetch = db_fetch_all($sql);
                    foreach ($fetch as $v):
                        $html .= "<div class=\"col-sm-3\">";
                        $html .= "<div class=\"Item\">";
                        $html .= "<div class=\"TopInfo\">";
                        // $html .= "<div class=\"RatingStars\">";
                        // $html .= "<span class=\"fa fa-star-o\" data-rating=\"1\"></span>";
                        // $html .= "<span class=\"fa fa-star-o\" data-rating=\"2\"></span>";
                        // $html .= "<span class=\"fa fa-star-o\" data-rating=\"3\"></span>";
                        // $html .= "<span class=\"fa fa-star-o\" data-rating=\"4\"></span>";
                        // $html .= "<span class=\"fa fa-star-o\" data-rating=\"5\"></span>";
                        // $html .= "<input type=\"hidden\" name=\"whatever1\" class=\"rating-value\" value=\"3\">";
                        // $html .= "</div>";
                        $html .= sprintf(
                            "<div class=\"Background\" style=\"background:url('%s');\"></div>",
                            $v['page_image']
                        );
                        // $html .= "<div class=\"UserCount\"><span>7</span></div>";
                        $html .= "</div>";
                        $html .= "<div class=\"BottomInfo\">";
                        $html .= sprintf(
                            "<div class=\"Title\" style=\"overflow:hidden\">%s</div>",
                            $v['page_title']
                        );
                        

                        if($v['page_menuid']==24){//catalog
                            $html .= sprintf(
                                "<div class=\"Day\">%s</div>",
                                menu_title(63)
                            );
                        }else{//pages
                            $html .= sprintf(
                                "<div class=\"Day\">%s</div>",
                                menu_title(86)
                            );
                        }

                        // $html .= "<div class=\"Price\">Package Price: <span>500 <i>A</i></span></div>";
                        $html .= "</div>";
                        $html .= "<div class=\"Buttons\">";

                        if($v['page_menuid']==24){//catalog
                            $link = href(63, array(), l(), $v['page_id']);
                        }else{//pages
                            $link = "/".l()."/blog/".urlencode($v['page_slug'])."/".$v['page_id'];
                        }

                        // $html .= "<a href=\"#\"><span class=\"CartIcon\"></span> Add To Cart</a>";
                        $html .= sprintf(
                            "<a href=\"%s\" style=\"width:%s\"><span class=\"More\"></span> %s</a>",
                            $link,
                            "100%",
                            l("more")
                        );
                        $html .= "</div>";
                        $html .= "</div>";
                        $html .= "</div>";
                    endforeach;
                    

                    $errorCode = 0;
                    $successCode = 1;
                    $errorText = "";
                    $successText = l("welldone");
                }
                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "count"=>count($fetch),
                        "output"=>$html,
                        "catalogs_count"=>$fetch[0]["page_catalog_count"],
                        "pages_count"=>$fetch[0]["page_pages_count"],
                        "Details"=>""
                    )
                );
                break;
            case 'changePaymentStatusFromAdmin':
                if(
                    empty($_POST["id"]) 
                ){
                    $errorCode = 1;
                    $successCode = 0;
                    $errorText = l("error");                   
                    $successText = "";
                }else{

                    $fetch = db_fetch("SELECT `status` FROM `cart` WHERE `id`='".(int)$_POST["id"]."'"); 

                    if(isset($fetch['status'])){

                        if($fetch['status']=="invoiced" || $fetch['status']=="unpayed"){
                            db_query("UPDATE `cart` SET `status`='payed' WHERE `id`='".(int)$_POST["id"]."'");
                        }else{
                            db_query("UPDATE `cart` SET `status`='unpayed' WHERE `id`='".(int)$_POST["id"]."'");
                        }

                        $errorCode = 0;
                        $successCode = 1;
                        $errorText = "";
                        $successText = l("welldone");
                    }
                }
                $out = array(
                    "Error" => array(
                        "Code"=>$errorCode, 
                        "Text"=>$errorText,
                        "Details"=>""
                    ),
                    "Success"=>array(
                        "Code"=>$successCode, 
                        "Text"=>$successText,
                        "Details"=>""
                    )
                );
                break;
            default:
                # code...
                break;
        }


    }

    echo json_encode($out);
?>