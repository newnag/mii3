<?php get_header(); ?>

<!-- กำหนดสิทธิ์เข้าชม -->
<?php
    global $user_ID;
    if($user_ID){
        $user = wp_get_current_user();
		
		if(has_category(26)){ ?>
			<div class="container">

            
            <?php while(have_posts()) : the_post()?>
                <div class="post-info">
                    <h1 class="title-post"><?php the_title(); ?></h1>
                    <div class="img-post"><?php the_post_thumbnail('medium'); ?></div>
                    <?php the_content() ?>
                    <!-- ลิ้งดาวโหลด -->
                    <a href="<?php echo get_post_meta( get_the_ID(), 'link_download', true ); ?>">
                        <?php echo get_post_meta( get_the_ID(), 'link_download', true ); ?>
                    </a>
                    <!-- ดูออนไลน์ -->
                    <?php
                        $stream = get_post_meta(get_the_ID(), 'link_steam', true);
                        if($stream){
                        ?>
                            <iframe src="<?php echo get_post_meta( get_the_ID(), 'link_steam', true ); ?>" frameborder="0" scrolling="no"></iframe>  <?php  
                        }
                    ?>
                </div>
            <?php endwhile;?>
		<?php }
		else{
		
        if ( in_array( 'vip', (array) $user->roles ) || 
            in_array( 'premium', (array) $user->roles ) ||
            in_array( 'administrator', (array) $user->roles )||
            in_array( 'mod', (array) $user->roles )) {
             ?>

            <!-- โพสเก่าและใหม่ -->
            <div class="container">

            
            <?php while(have_posts()) : the_post()?>
                <div class="post-info">
                    <h1 class="title-post"><?php the_title(); ?></h1>
                    <div class="img-post"><?php the_post_thumbnail('medium'); ?></div>
                    <?php the_content() ?>
                    <!-- ลิ้งดาวโหลด -->
                    <a href="<?php echo get_post_meta( get_the_ID(), 'link_download', true ); ?>">
                        <?php echo get_post_meta( get_the_ID(), 'link_download', true ); ?>
                    </a>
                    <!-- ดูออนไลน์ -->
                    <?php
                        $stream = get_post_meta(get_the_ID(), 'link_steam', true);
                        if($stream){
                        ?>
                            <iframe src="<?php echo get_post_meta( get_the_ID(), 'link_steam', true ); ?>" frameborder="0" scrolling="no"></iframe>  <?php  
                        }
                    ?>
                </div>
            <?php endwhile;?>

        <?php
        }
        else{?>
            <!-- เตือนสมาชิกธรรมดา -->
            <div class="text-notvip">
                <h1>สมัครสมาชิก VIP เพื่อเข้ารับชมเนื้อหา</h1>
                <p>เพื่อเข้ารับชมเนื้อหาและดาวโหลด ท่านสามารถสมัคร VIP ได้จากลิ้งด้านล่างนี้ หรือติดต่อทางไลน์</p>
                <img src="https://qr-official.line.me/sid/M/562dtrhj.png">
                <a href="http://nav.cx/4ZQt3qb"><img src="https://scdn.line-apps.com/n/line_add_friends/btn/th.png" alt="เพิ่มเพื่อน" height="36" border="0"></a>
            </div>
            
        <?php
        }
    }
	}
    else{?>
        <div class="text-notvip">
            <h1>ท่านยังไม่เข้าสู่ระบบ กรุณาเข้าสู่ระบบเพื่อรับชมเนื้อหา</h1>
            <p>เพื่อการเข้าชมเนื้อหาและการดาวโหลด ท่านจำเป็นต้องเข้าสู่ระบบเพื่อใช้งานเว็บไซต์ 
            หากท่านยังไม่ได้สมัครสมาชิก กรุณาสมัครสมาชิก หรือติดต่อทางไลน์เพื่อขอสมัคร VIP</p>
            <img src="https://qr-official.line.me/sid/M/562dtrhj.png">
            <a href="http://nav.cx/4ZQt3qb"><img src="https://scdn.line-apps.com/n/line_add_friends/btn/th.png" alt="เพิ่มเพื่อน" height="36" border="0"></a>
        </div>
    <?php
    }
	
?>

</div>


<?php get_footer(); ?>