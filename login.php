<?php
/* Template Name: Login*/
global $wpdb,$user_ID;

if(!$user_ID){

    if($_POST){

        $username = $wpdb->escape($_POST['username']);
        $password = $wpdb->escape($_POST['password']);

        $login_array = array();
        $login_array['user_login'] = $username;
        $login_array['user_password'] = $password;

        $vertify_user = wp_signon($login_array,true);
        if(!is_wp_error($vertify_user)){
            echo "<script>window.location = '".site_url()."' </script>";
            
        }
        else{
            echo "<p>Login Not Success</p>";
        }
    }
    else{

        get_header();

        ?>

        <div class="content-login">
        
        <h1>เข้าสู่ระบบ</h1>

        <form class="login-form" method="post">
            <div class="user-input">
                <p>
                    <label>Username</label>
                    <input type="text" name="username" id="username" placeholder="Username">
                </p>
            
                <p>
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="password">
                </p>
            </div>
        
            <button type="submit">Login</button>
        
        </form>

        </div>

<?php
    }
}

else{

}

get_footer();?>

