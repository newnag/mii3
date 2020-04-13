<?php 
    global $user_ID;
    if($user_ID){
        $user = wp_get_current_user();
        if ( in_array( 'vip', (array) $user->roles ) || 
            in_array( 'premium', (array) $user->roles ) ||
            in_array( 'administrator', (array) $user->roles )||
            in_array( 'mod', (array) $user->roles )) {
            ?>
        
        <?php
        }
        else{
            echo "กรุณาสมัคร VIP เพื่อรับชมเนื้อหา";
        }
    }
    else{
        echo "กรุณาเข้าสู่ระบบ";
    }
?>