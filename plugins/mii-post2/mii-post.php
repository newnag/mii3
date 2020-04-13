<?php
	 /*
	 * Plugin Name: Mii-Post2
	 * Plugin URI: https://mii-moi.com
	 * Description: สำหรับการโพสงานเว็บ Mii-Moi
	 * Version: 1.0.0
	 * Author: Nexodius
	 */
?>
<?php
	// ปิด content edit
	function RemoveContent_edit(){
		remove_post_type_support( 'mii2', 'editor');
	}
	add_action('admin_init','RemoveContent_edit');

    // สร้างโพสงาน
	function create_post_typeMii2(){
        $labels = array(
            'name'                  => _x( 'โพสงาน', 'Post type general name', 'textdomain' ),
            'singular_name'         => _x( 'โพสงาน', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'โพสงาน', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'โพสงาน', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'เพิ่มงานใหม่', 'textdomain' ),
            'add_new_item'          => __( 'โพสงานใหม่', 'textdomain' ),
            'new_item'              => __( 'New Book', 'textdomain' ),
            'edit_item'             => __( 'แก้ไข', 'textdomain' ),
            'view_item'             => __( 'ตรวจดูงาน', 'textdomain' ),
            'all_items'             => __( 'งานทั้งหมด', 'textdomain' ),
            'search_items'          => __( 'ค้นหางาน', 'textdomain' ),
            'parent_item_colon'     => __( 'Parent Books:', 'textdomain' ),
            'not_found'             => __( 'ไม่พบโพสงาน', 'textdomain' ),
            'not_found_in_trash'    => __( 'ไม่พบโพสงานในถังขยะ', 'textdomain' ),
            'featured_image'        => _x( 'รูปปกเรื่อง', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'set_featured_image'    => _x( 'ใส่รูปปกเรื่อง', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'remove_featured_image' => _x( 'ลบรูปปก', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'use_featured_image'    => _x( 'ใช้เป็นรูปปก', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
            'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
            'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
            'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
            'items_list'            => _x( 'รายการงาน', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
        );
    
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title','thumbnail' ),
        );
        register_post_type( 'mii2', $args );
    }
	add_action('init','create_post_typeMii2');
    
    
    // เปลี่ยน text title
    function wpb_change_title_text( $title ){
        $screen = get_current_screen();
     
        if  ( 'mii2' == $screen->post_type ) {
             $title = 'ชื่อเรื่อง';
        }
     
        return $title;
   }
   add_filter( 'enter_title_here', 'wpb_change_title_text' );

   // เพิ่ม meta box
    function adding_custom_meta_boxes( ) {
        //ลิ้งค์ดาวโหลด
        add_meta_box( 'link_main','ลิ้งค์ดาวโหลด','mii2_postLink_function','mii2','normal','default');
        //ลิ้งค์ดูออนไลน์
        add_meta_box( 'link_steam','ลิ้งดูออนไลน์','mii2_postSteam_function','mii2','normal','default');
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
        $post_slug = 'mii2';
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
        $post_slug = 'mii2';
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

    // เปลี่ยน label cate
	function tft_change_taxonomy_vehicle_type_label() { $t = get_taxonomy('category');
		$t->labels->name                            = 'หมวดหมู่';
        $t->labels->singular_name                   = 'Story Author';
        $t->labels->menu_name                       = 'หมวดหมู่';
        $t->labels->all_items                       = 'หมวดหมู่ทั้งหมด';
        $t->labels->new_item_name                   = 'แก้ไขชื่อ';
        $t->labels->add_new_item                    = 'เพิ่ม';
        $t->labels->edit_item                       = 'แก้ไข';
        $t->labels->update_item                     = 'แก้ไขหมวดหมู่';
        $t->labels->search_items                    = 'ค้นหาหมวดหมู่';
	}
    add_action( 'wp_loaded', 'tft_change_taxonomy_vehicle_type_label', 20);
    
?>