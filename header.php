<!DOCTYPE html>
<html lang="en">

	<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-136721879-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-136721879-2');
</script>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php bloginfo('template_url');?>/style.css?v=<?=date('his')?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
</head>
<?php wp_head(); ?>
<body>
    <div class="header">
        <div class="img-head-1"><img src="<?php site_url(); ?>/wp-content/themes/theme-mii2/img/mii.png" alt=""></div>
        <h1>เว็บหมีโม่ย</h1>
        <div class="img-head-2"><img src="<?php site_url(); ?>/wp-content/themes/theme-mii2/img/70595273_342293419851731_1348412653390790656_n.png" alt=""></div>
        <div id="mobile-menu">&#9776;</div>
        <ul class="navmenu">
            <?php
                global $current_user;

                get_currentuserinfo();

                switch(true){
                    case(user_can($current_user,"vip")):?>
                    <?php wp_nav_menu( array( 'menu' => 'vip_login_menu' ) );
                    break;

                    case(user_can($current_user,"premium")):?>
                    <?php wp_nav_menu( array( 'menu' => 'vip_login_menu' ) );
                    break;

                    case(user_can($current_user,"administrator")):?>
                    <?php wp_nav_menu( array( 'menu' => 'vip_login_menu' ) );
                    break;

                    case(user_can($current_user,"mod")):?>
                    <?php wp_nav_menu( array( 'menu' => 'vip_login_menu' ) );
                    break;

                    case(user_can($current_user,"subscriber")):?>
                    <?php wp_nav_menu( array( 'menu' => 'login_menu' ) );
                    break;

                    default:
                    wp_nav_menu( array( 'menu' => 'guest_menu' ) );
                    break;
                }
            ?>
            
        </ul>
        <span id="close-menu">X</span>
        
    </div>

    