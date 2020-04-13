<?php
/* Template Name: Resigter*/
global $wpdb,$user_ID;

get_header();

if($user_ID){
    header('Location:' .home_url());
}
else{
    if($_POST){

        $username = $wpdb->escape($_POST['username']);
        $password = $wpdb->escape($_POST['password']);
        $Confpassword = $wpdb->escape($_POST['confirmpassword']);
        $email = $wpdb->escape($_POST['email']);
    
        $error = array();
    
        // เช็คช่องว่าง
        if(strpos($username, ' ') !== FALSE){
            $error['username_space'] = "ห้ามมีช่องว่าง หรือ space bar";
        }
    
        // เช็คไม่ได้กรอก
        if(empty($username)){
            $error['username_empty'] = "กรุณากรอก user";
        }
    
        // เช็คยูสมีในระบบ
        if(username_exists( $username )){
            $error['username_exists'] = "Username นี้มีในระบบแล้ว";
        }

        // เช็คพาสเวิร์ดตรงกัน
        if(0 === preg_match("/.{6,}/", $_POST['password'])){  
            $error['password'] = "รหัสผ่าน ต้องมีอย่างน้อย 6 ตัวขึ้นไป";  
        } 

        // เช็คพาสเวิร์ดอีกครั้ง
        if(strcmp($password,$Confpassword)!==0){
            $error['password_confirm'] = "รหัสผ่านไม่ตรงกัน";
        }

        // เช็คอีเมล์
        if(!is_email($email)){
            $error['email'] = "กรุณาใส่อีเมล์"; 
        }

        if(email_exists($email)){
            $error['email_already'] = "อีเมล์นี้มีอยู่ในระบบแล้ว";  
        }
    
        if(count($error) == 0){
            wp_create_user($username,$password,$email);
            echo "<p style='text-align:center;font-size:20px;'>การสมัครสำเร็จแล้ว</p>";
            exit();
        }
        else{
            print_r($error);
        }
    }
}


?>

<form class="form-register" method="post">
<p>
    <label>Username</label>
    <input type="text" name="username" id="username" placeholder="Username">
</p>

<p>
    <label>Password</label>
    <input type="password" name="password" id="password" placeholder="Password">
</p>

<p>
    <label>Confirm Password</label>
    <input type="password" name="confirmpassword" id="confirmpassword" placeholder="Password">
</p>

<p>
    <label>Email</label>
    <input type="email" name="email" id="email" placeholder="Email">
</p>

<div class="button-register">
    <button type="submit" value="Submit">สมัครสมาชิก</button>
    <!-- <a href=""><button class="info-vip">รายละเอียด VIP</button></a> -->
</div>

</form>

<?php get_footer();?>