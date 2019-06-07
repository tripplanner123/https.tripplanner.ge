<?php defined('DIR') OR exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <base href="<?php echo href() ?>" />
        <meta http-equiv="content-type" content="text/html;charset=<?php echo c('output.charset') ?>" />
        <title>Digital Design Smart CMS</title>
        <link type="text/css" rel="stylesheet" href="<?php echo CMS;?>/css/style-en.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/css/dropdown.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT;?>/css/lightbox.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT ?>/fancybox/css/jquery.fancybox2.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo JAVASCRIPT ?>/beatpicker/beatpicker.min.css" />
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery.dropdown.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/jquery/jquery.hoverIntent.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/height-cms.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/base64.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT;?>/tinymce/tinymce.min.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT ?>/fancybox2/jquery.fancybox.js"></script>
        <script type="text/javascript" src="<?php echo JAVASCRIPT ?>/beatpicker/beatpicker.min.js"></script>
        <script type="text/javascript">
            tinymce.init({
                mode: "specific_textareas",
                editor_selector: "editor",
                plugins: [
                        "advlist autolink autosave link image responsivefilemanager lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern"
                ],

                toolbar1: "newdocument | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontsizeselect",
                toolbar2: "responsivefilemanager | cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
                toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

                relative_urls: false,
                image_advtab: true,
                menubar: true,
                toolbar_items_size: 'small',
                // style_formats: [
                //     {title: 'Bold text', inline: 'b'},
                //     {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                //     {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                //     {title: 'Example 1', inline: 'span', classes: 'example1'},
                //     {title: 'Example 2', inline: 'span', classes: 'example2'},
                //     {title: 'Table styles'},
                //     {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                // ],
                templates: [
                    {title: 'Test template 1', content: 'Test 1'},
                    {title: 'Test template 2', content: 'Test 2'}
                ],
                filemanager_crossdomain: false,
                external_filemanager_path: "<?php echo JAVASCRIPT ?>/tinymce/filemanager/",
                filemanager_title: "Filemanager",
                external_plugins: {"filemanager" : "filemanager/plugin.min.js"}, 
                extended_valid_elements : "iframe[src|frameborder|style|scrolling|class|width|height|name|align]"
            });
        </script>
    </head>
    <body>
        <div id="digital">
            <div id="header">
                <a href="<?php echo ahref(array('main')) ?>"><img src="<?php echo CMS;?>/img/logo.png" width="300" height="23" alt="" id="logo"/></a>
                <a href="<?php echo ahref(array('access', 'logout')) ?>" id="logout"><?php echo a("logout");?></a>
                <a href="<?php echo c('site.url') ?>" id="site" class="right">საიტზე გადასვლა</a>
                <span id="welcome">
                    <?php echo a("user"); ?>:
                    <span id="welcome_user"><?php echo $_SESSION['auth']['username'] ?></span>
                    (<?php echo $_SESSION['auth']['usercat'] ?>)
                </span>
            </div>
			<!-- CMS Main Menu -->
            <div id="mainmenu"><?php require(CMS . "/templates/mainmenu.php"); ?></div>
			<!-- CMS Main Menu -->
            <?php
                $route = Storage::instance()->route;
                if ($route[1] != 'users' && $route[1] != 'siteusers' && $route[1] != 'userrights'):
            ?>
            <!-- Site Language Switcher -->
            <div id="language"><ul><?php require(CMS . "/templates/language.php"); ?></ul></div>
            <!-- Site Language Switcher -->
            <?php else: ?>
               <div id="language" style="color:#fff;"><?php echo l_long(l()); ?></div>
            <?php endif; ?>
            <div class="clear"></div>
            <div id="line"></div>
            <!-- CMS Content -->
            <div id="content">
                <?php
                    echo $content;
                ?>
			</div>
			<!-- CMS Content -->
            <div id="preloader"><img src="_manager/img/preloader.gif"  /></div>
        </div>
        <!-- Footer -->
        <div id="footer">
            <div class="part">
                <div class="menu"><a href="<?php echo ahref(array('terms')) ?>"><?php echo a("terms");?></a> | <a href="<?php echo ahref(array('privacy')) ?>"><?php echo a("privacy");?></a></div>
                <div class="contact">For support call: +995 32 2473211,  E-mail: <a href="mailto:info@digitaldesign.ge">info@digitaldesign.ge</a></div>
                <div class="copyright"><?php echo a("copyright"); ?></div>
            </div>
        </div>
        <!-- Footer -->
    </body>
</html>