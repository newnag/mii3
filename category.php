<?php get_header(); ?>

<?php
    global $user_ID;
    //$slug = home_url( $wp->request );
    $user = wp_get_current_user();
    //echo $slug;
    $term = get_queried_object();
    $url = urldecode($term->slug);
    //echo $url;

    if($url === 'ดูฟรี'){
        $member = in_array( 'subscriber', (array) $user->roles ) ||
                    in_array( 'administrator', (array) $user->roles )||
                    in_array( 'premium', (array) $user->roles )||
                    in_array( 'vip', (array) $user->roles )||
                    in_array( 'mod', (array) $user->roles );
    }
    else{
        $member = in_array( 'administrator', (array) $user->roles )||
                    in_array( 'premium', (array) $user->roles )||
                    in_array( 'vip', (array) $user->roles )||
                    in_array( 'mod', (array) $user->roles );
    }

    if($user_ID){ 
        if($member){ ?>
            <div class="container">

                <div class="box-cat">
                    <?php 
                    
                    $args = array(
                    'post_type' => 'mii2',
                    'category_name' =>  $url
                    );
                    $query = new WP_Query($args);
                    while( $query->have_posts()) : $query->the_post() ?>

                        <a href="<?php the_permalink(); ?>">
                            <div class="box-cat-item">
                                <div class="box-cat-img">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                                <h1><?php the_title(); ?></h1>
                            </div>
                        </a>

                    <?php endwhile; wp_reset_query() ;  ?>


                    <?php while(have_posts()) : the_post() ?>

                        <a href="<?php the_permalink(); ?>">
                            <div class="box-cat-item">
                                <div class="box-cat-img">
                                    <?php the_post_thumbnail(); ?>
                                </div>
                                <h1><?php the_title(); ?></h1>
                            </div>
                        </a>

                    <?php endwhile; ?>


                </div>   
                <?php if ( function_exists( 'pgntn_display_pagination' ) ) pgntn_display_pagination( 'posts' ); ?>
            </div> 
        <?php }
        else{ ?>
            <!-- เตือนสมาชิกธรรมดา -->
            <div class="text-notvip">
                <h1>สมัครสมาชิก VIP เพื่อเข้ารับชมเนื้อหา</h1>
                <p>เพื่อเข้ารับชมเนื้อหาและดาวโหลด ท่านสามารถสมัคร VIP ได้จากลิ้งด้านล่างนี้ หรือติดต่อทางไลน์</p>
                <img src="https://qr-official.line.me/sid/M/562dtrhj.png">
                <a href="http://nav.cx/4ZQt3qb"><img src="https://scdn.line-apps.com/n/line_add_friends/btn/th.png" alt="เพิ่มเพื่อน" height="36" border="0"></a>
            </div>
        <?php }

    ?>
    
<?php
    }
    else{
        echo "กรุณาเข้าสู่ระบบ";
    }
?>



<?php get_footer(); ?>