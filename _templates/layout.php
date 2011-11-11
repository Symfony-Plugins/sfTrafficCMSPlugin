<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <link media="all" type="text/css" rel="stylesheet" href="http://symfony.com/css/common/reset.css" />
    <link media="all" type="text/css" rel="stylesheet" href="http://symfony.com/css/common/base.css" />
    <link media="all" type="text/css" rel="stylesheet" href="http://symfony.com/css/common/header.css" />
    <link media="all" type="text/css" rel="stylesheet" href="http://symfony.com/css/common/menu.css" />
    <link media="all" type="text/css" rel="stylesheet" href="http://symfony.com/css/common/footer.css" />
    <link media="all" type="text/css" rel="stylesheet" href="http://symfony.com/css/common/layout.css" />
    <link media="all" type="text/css" rel="stylesheet" href="http://symfony.com/css/common/common.css" />
    
    <style type="text/css">
        
        body { font-size: 14px; color: #2F2F2F; background: #313131; font-family: "Lucida Sans Unicode","Lucida Grande",Verdana,Arial,Helvetica,sans-serif; }
        .illustration_logo_header a { display: block; height: 60px;text-indent: -9999px; width: 240px;background:url(http://symfony.com/images/common/logo/logo_symfony_header.png) ;  }
        .box_download { width: auto; }
        .box_download h2 { padding-top: 26px; text-align: right; font-weight: bold; font-size: 20px; }
        .main_menu ul { width: 966px; }
        .main_menu li { border-right: 1px solid #B9B9B9; border-left: 0; }
        .main_menu li:first-child {  }
        .main_menu li:last-child { float: right; border-right: 0; border-left: 1px solid #B9B9B9; }
        .main_menu li a, .main_menu li a:hover { padding:  10px 20px; }
        .main_menu li:first-child, .main_menu li:first-child a:hover { border-radius: 8px 0 0 8px; -moz-border-radius: 8px 0 0 8px; -webkit-border-radius: 8px 0 0 8px; }
        .main_menu li:last-child, .main_menu li:last-child a:hover { border-radius: 0 8px 8px 0; -moz-border-radius: 0 8px 8px 0; -webkit-border-radius: 0 8px 8px 0; }
        
        .notice { background:#F4F4F4; font-weight: bold; padding: 10px 20px; }
        
        h1 { font-family:  Georgia,"Times New Roman",Times,serif; font-size: 40px; padding-bottom: 24px; }
        h2 { font-size: 20px; padding-bottom: 12px; font-weight: bold;  }
        a { color: #000; }
        select { font-size: 12px; }
        
        #content_wrapper { background: #fff; }
        #sf_admin_container {  }
        #sf_admin_bar { float: left; width: 320px; padding-right: 34px; }
        #sf_admin_bar table { width: 100%; background: 0; border: 0; border-top: 1px dashed #999; }
        #sf_admin_bar table tr { border: 0; border-bottom: 1px dashed #999; }
        #sf_admin_bar table th, 
        #sf_admin_bar table td { vertical-align: top; border: 0; padding: 12px 0 0; }
        #sf_admin_bar table td input,
        #sf_admin_bar table td select { margin: 0 0 12px; max-width: 200px; }
        #sf_admin_bar table td label { width: 100px; }
        #sf_admin_bar table tfoot td { background: 0; }

        #sf_admin_content {  }
        #sf_admin_content br { display: none; }
        #sf_admin_content table { width: auto; }
        #sf_admin_content table td { font-family: monospace; }
         
        
        
        table { background: #fff; border: 1px solid #999; margin: 0 0 24px; }
        table tr { border: 0;  }
        table th, 
        table td { word-wrap: break-word; font-size: 12px; padding:  6px; border: 0; border-bottom: 1px solid #999; border-right: 1px solid #999; }
        table th,
        table tfoot td { background: #f4f4f4; font-size: 14px; padding: 12px 6px; }
        table tfoot td { text-align: right; }
        table th a { text-shadow: 0 1px 0 #fff; }
        table td a { color: #759E1A; }
        table td .sf_admin_action_delete a { box-shadow: none; -moz-box-shadow: none; -webkit-box-shadow:none; font-family: monospace; padding: 0; background: 0; display: block; float: none; font-size: 12px; line-height: 1; margin: 0;  }
        table td .sf_admin_action_delete a:hover { text-decoration: underline; box-shadow: none; -moz-box-shadow: none; -webkit-box-shadow:none; }
        table td label { display: inline-block; width: 65px; }
        table td input[type=text],
        table td input[type=password]{  padding: 5px; background: #f4f4f4; border: 1px solid #999999; font-family: monospace; width: 94%; }
        table td input[type=text]:focus,
        table td input[type=password]:focus{ border-color:#759E1A; background: #fff;  }
        
        
        fieldset { margin: 0 0 48px; padding: 0 0 8px; border-bottom: 1px dashed #999; }
        fieldset img { height: auto; margin: 0 12px 0 0; width: 250px; }
        fieldset table { display: inline-table; }
        fieldset .sf_admin_form_row { padding: 8px 0 0; border-top: 1px dashed #999; margin: 8px 0 0; }
        fieldset select { min-width: 400px; }
        fieldset label { width: 165px; display: inline-block; }
        fieldset .content { width: auto; display: inline; }
        fieldset .content input[type=text],
        fieldset .content input[type=password] {  font-size: 11px; padding: 5px; background: #f4f4f4; border: 1px solid #999999; font-family: monospace;width: 40%; }
        fieldset .content input[type=text]:focus,
        fieldset .content input[type=password]:focus{ border-color:#759E1A;  background: #fff;  }
        fieldset .content table td input[type=text],
        fieldset .content table td input[type=password] { width: 94%; }
        
        
        .sf_admin_action_save_and_add input,
        .sf_admin_action_save input,
        .sf_admin_action_list a, 
        .sf_admin_action_delete a, 
        .sf_admin_action_new a { background: url("http://symfony.com/images/common/backgrounds/bg_menu.gif") repeat-x scroll left bottom #fff;
            font-family: arial;
            border-radius: 30px;
            -moz-border-radius: 30px;
            -webkit-border-radius: 30px;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
            -moz-box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
            -webkit-box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);
            display: inline-block;
            border: 0;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            margin: 24px 0;
            padding: 8px 40px;
            text-shadow: 0 1px 0 #FFFFFF; 
        }
        
        .sf_admin_action_save_and_add input:hover,
        .sf_admin_action_save input:hover,
        .sf_admin_action_list a:hover, 
        .sf_admin_action_delete a:hover, 
        .sf_admin_action_new a:hover {
            text-decoration: none;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
            -moz-box-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
            -webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.5);
        }
        
        .sf_admin_action_new a { clear: right; }
         
        .sf_admin_action_delete a,
        .sf_admin_action_list a { float: left; }
        .sf_admin_action_delete a { margin-right: 24px; color: #ff0000; }
        
        .sf_admin_action_save_and_add input,
        .sf_admin_action_new a,
        .sf_admin_batch_actions_choice,
        .sf_admin_action_save input { float: right; }
        .sf_admin_action_save_and_add input,
        .sf_admin_action_save input { color: #759E1A; margin-left: 24px;}
        
        table tfoot td input,
        .sf_admin_batch_actions_choice input {  background: #f4f4f4; padding: 3px 20px; border-radius: 30px; -moz-border-radius: 30px; -webkit-border-radius: 30px; border: 1px solid #999999; margin-left: 24px; cursor: pointer;  font-weight: normal;  font-size: 12px; text-transform: capitalize; }
        
        table tfoot td input:hover,
        .sf_admin_batch_actions_choice input:hover { background: #ddd; }
        
    </style>
    
    <?php include_javascripts() ?>
  </head>
  <body>
      
      
      
      <div id="content_wrapper">
        <div class="content">
            <div class="header">
                <div class="content_header clear_fix">
                    <div class="illustration_logo_header">
                        <a href="/">Symfony</a>
                    </div>
                    <div class="box_download">
                        <h2>BA Behind The Design</h2>
                    </div>
                </div>
            </div>
            <div class="main_menu clear_fix">
                <?php echo include_partial('sfTrafficCMSPlugin/navigation_menu') ?>
            </div>
            <div class="main_content">
                <div class="box_columns clear_fix">
                    <?php echo $sf_content ?>
                </div>
            </div>
        </div>
        <div class="footer">
        <div class="content">
            <h2 class="title_02">
                Traffic Digital 2011
            </h2>
        </div>
    </div>
  </body>
</html>







    