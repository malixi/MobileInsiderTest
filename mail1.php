<?php 

DEFINE ('DB_USER', 'root');
DEFINE ('DB_PASSWORD', '');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'storeb');

if(isset($_POST['submit'])){
$emails=$_POST['email'];
$query="select * from user where email='$emails'";
$result=mysql_query($query);
if(mysql_num_rows($result)){
$code=rand(100,999);
$new_pass = md5($code);
$emails=$_POST['email'];
mysql_query("update user set password='$new_pass' where email='$emails'");
$subject = 'New Password';
$emails=$_POST['email'];
$email = htmlspecialchars($emails);
$message = "Good Day this is AA2000 Security and Technology Solution Inc. <br> Your Requested Password is".$code."<br>"."Don't forget to change your password!<br>"."Thank you!";
$to = htmlspecialchars($emails);
mail($to, $subject, $message);
?>
<script>
alert('Your New Password is Send to your Email');
window.location="index.php";
</script>
<?php
}
else
{
    ?>
<script>
alert('No user exist with this Email address');
 window.location='forgotpass.php';</script>
 <?php
}
}

?>

