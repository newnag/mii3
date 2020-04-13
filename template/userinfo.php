<?php 
/*
Template Name: user_info
*/
get_header(); ?>

<?php global $current_user; $wp_roles;
            
    get_currentuserinfo(); ?>

    <p style="text-align:center;">ชื่อสมาชิก : <?php echo $current_user->user_login ?></p>
    <p style="text-align:center;">อีเมล์สมาชิก : <?php echo $current_user->user_email ?></p>
    <?php 

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    // echo translate_user_role( $wp_roles->roles[ $user_role ]['name'] ); // If you're using multiple languages

    ?>
    <p style="text-align:center;">สถานะสมาชิก : <?php echo $wp_roles->roles[ $user_role ]['name']; ?> </p>

      


<?php get_footer(); ?>