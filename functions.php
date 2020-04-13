<?php


    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    

    // สร้างเมนู
	register_nav_menus(
		array(
            'mainmenu' => 'mainmenu',
            'footer' =>  'Footer Menu' ,
		)
    );

    // เพิ่ม taxonomy ไป miiv2
	function customTax_miiv2(){
		register_taxonomy_for_object_type('category','mii2');
	}
    add_action('init','customTax_miiv2');

    // เปลี่ยนเส้นทาง logout
    function redirect_to_custon_login(){
        wp_redirect(site_url() . "/login");
        exit();
    }
    add_action("wp_logout","redirect_to_custon_login");

    // ปิด admin bar
    if ( ! current_user_can( 'manage_options' ) ) {
        add_filter('show_admin_bar', '__return_false');
    }


    // ปุ่มออกจากระบบ
    add_filter( 'wp_nav_menu_items', 'wti_loginout_menu_link', 10, 2 );
    function wti_loginout_menu_link( $items, $args ) {
    if ($args->menu == 'login_menu') {
        if (is_user_logged_in()) {
            $items .= '<li class="right"><a href="'. wp_logout_url() .'">'. __("Logout") .'</a></li>';
        } else {
            $items .= '<li class="right"><a href="'. site_url() .'/login">'. __("Login") .'</a></li>';
        }
    }
    elseif($args->menu == 'vip_login_menu') {
        if (is_user_logged_in()) {
            $items .= '<li class="right"><a href="'. wp_logout_url() .'">'. __("Logout") .'</a></li>';
        } else {
            $items .= '<li class="right"><a href="'. site_url() .'/login">'. __("Login") .'</a></li>';
        }
    }
    elseif ($args->menu == 'guest_menu'){
        $items .= '<li class="right"><a href="'. site_url() .'/login">'. __("Login") .'</a></li>';
    }
    return $items;
    }

    // เมนูข้อมูลสมาชิก
    add_filter( 'wp_nav_menu_items', 'mii_info_user_menu', 9, 2 );
    function mii_info_user_menu( $items, $args ) {
        if ($args->menu == 'vip_login_menu') {
            if (is_user_logged_in()) {
                $items .= '<li class="right"><a href="'. site_url() .'/userinfo">'. __("Profile") .'</a></li>';
            } 
        }
        elseif ($args->menu == 'login_menu'){
            $items .= '<li class="right"><a href="'. site_url() .'/userinfo">'. __("Profile") .'</a></li>';
        }
        return $items;
    }

    // เพิ่ม role
    add_role('vip','VIP',array());
    add_role('premium','Premium',array());
    add_role('mod','Mod',array());
    
    // จัดการสิทธิ์ role
    function role_vip(){
		$vip_cap = get_role('vip');

        $vip_cap->add_cap( 'read' );
	}
    add_action('init','role_vip');
    
    function role_mod(){
		$mod_cap = get_role('mod');

        $mod_cap->add_cap( 'read' );
        $mod_cap->add_cap( 'edit_posts' );
		$mod_cap->add_cap( 'delete_posts' );
		$mod_cap->add_cap( 'delete_published_posts' );
		$mod_cap->add_cap( 'delete_others_posts' );
        $mod_cap->add_cap( 'edit_others_posts' );
        $mod_cap->add_cap( 'edit_published_posts' );
        $mod_cap->add_cap( 'publish_posts' );
        $mod_cap->add_cap( 'upload_files' );
        $mod_cap->add_cap( 'delete_posts' );

        $mod_cap->add_cap( 'list_users' ); 
        $mod_cap->add_cap( 'edit_users' );
        $mod_cap->add_cap( 'create_users' );
        $mod_cap->add_cap( 'add_users' );
        $mod_cap->add_cap( 'delete_users' );
        $mod_cap->add_cap( 'promote_users' );
	}
    add_action('init','role_mod');
    
    // ปิด content edit
    function RemoveContent_edit(){
		remove_post_type_support( 'post', 'editor');
    }
    add_action('admin_init','RemoveContent_edit');
    
    // เพิ่ม meta box
    function adding_custom_meta_boxes( ) {
        //ลิ้งค์ดาวโหลด
        add_meta_box( 'link_main','ลิ้งค์ดาวโหลด','mii2_postLink_function','post','normal','default');
        //ลิ้งค์ดูออนไลน์
        add_meta_box( 'link_steam','ลิ้งดูออนไลน์','mii2_postSteam_function','post','normal','default');
    }
    add_action( 'add_meta_boxes', 'adding_custom_meta_boxes', 10, 2 );

    //ฟังค์ชั่นของ meta box link download
    function mii2_postLink_function($post){
        wp_nonce_field( basename(__FILE__),'wp_cpt_nonce' );
        ?>
        <span>กรอกลิ้งดาวโหลดที่นี่</span> <br>
        <?php $link_download_name = get_post_meta($post->ID,'link_download',true); ?>
        <input style='width:100%;' type='text' name='link_download' value="<?php echo $link_download_name ;?>"> <?php
    }

    add_action( 'save_post', 'save_link_download', 10, 2 );
    function save_link_download($post_id,$post){
        //verify nonce
        if(!isset($_POST['wp_cpt_nonce']) || !wp_verify_nonce($_POST['wp_cpt_nonce'],basename(__FILE__))){
            return $post_id;
        }
        // verify slug
        $post_slug = 'post';
        if($post_slug != $post->post_type){
            return;
        }
        //save db
        $pub_link_load = '';
        if(isset($_POST['link_download'])){
            $pub_link_load = sanitize_text_field($_POST['link_download']);
        }else{
            $pub_link_load = '';
        }
        update_post_meta($post_id,'link_download',$pub_link_load);
    }

    //ฟังค์ชั่นของ meta box link steam
    function mii2_postSteam_function($post){
        wp_nonce_field( basename(__FILE__),'wp_cpt_nonce' );

        ?>
        <span>กรอกลิ้งดูออนไลน์ที่นี่</span> <br>
        <?php $link_steam_name = get_post_meta($post->ID,'link_steam',true); ?>
        <input style='width:100%;' type='text' name='link_steam' value="<?php echo $link_steam_name ;?>"> <?php
    }

    add_action( 'save_post', 'save_link_steam', 10, 2 );
    function save_link_steam($post_id,$post){
        //verify nonce
        if(!isset($_POST['wp_cpt_nonce']) || !wp_verify_nonce($_POST['wp_cpt_nonce'],basename(__FILE__))){
            return $post_id;
        }
        // verify slug
        $post_slug = 'post';
        if($post_slug != $post->post_type){
            return;
        }
        //save db
        $pub_link_load = '';
        if(isset($_POST['link_steam'])){
            $pub_link_load = sanitize_text_field($_POST['link_steam']);
        }else{
            $pub_link_load = '';
        }
        update_post_meta($post_id,'link_steam',$pub_link_load);
    }
?>