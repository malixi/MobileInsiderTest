<?php

mysql_connect("localhost", "root", "") or die("Error connecting to database: ".mysql_error());
mysql_select_db("storeb") or die(mysql_error());
    

//This code runs if the form has been submitted
if (isset($_POST['submit']))
{

// check for valid email address
$email = $_POST['remail'];
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
     $error[] = 'Please enter a valid email address';
}

// checks if the username is in use
$check = mysql_query("SELECT email FROM user WHERE email = '$email'")or die(mysql_error());
$check2 = mysql_num_rows($check);

//if the name exists it gives an error
if ($check2 == 0) {
$error[] = 'Sorry, we cannot find your account details please try another email address.';
}

// if no errors then carry on
if (!$error) {

$query = mysql_query("SELECT first_name FROM user WHERE email = '$email' ")or die (mysql_error());
$r = mysql_fetch_object($query);

//create a new random password

$password = substr(md5(uniqid(rand(),1)),3,10);
$pass = md5($password); //encrypted version for database entry

//send email
$to = "$email";
$subject = "Account Details Recovery";
$body = "Hi $r->first_name, nn you or someone else have requested your account details. nn Here is your account information please keep this as you may need this at a later stage. nnYour username is $r->first_name nn your password is $password nn Your password has been reset please login and change your password to something more rememberable.nn Regards Site Admin";
$additionalheaders = "From: <user@domain.com>rn";
$additionalheaders .= "Reply-To: noprely@domain.com";
mail($to, $subject, $body, $additionalheaders);

//update database
$sql = mysql_query("UPDATE user SET password='$pass' WHERE email = '$email'")or die (mysql_error());
$rsent = true;


}// close errors
}// close if form sent

//show any errors
if (!empty($error))
{
        $i = 0;
        while ($i < count($error)){
        echo "<div class='msg-error'>".$error[$i]."</div>";
        $i ++;}
}// close if empty errors


if ($rsent == true){
    echo "<p>You have been sent an email with your account details to $email</p>n";
    } else {
    echo "<p>Please enter your e-mail address. You will receive a new password via e-mail.</p>n";
    }

?>

<form action="" method="post">
<p>Email Address: <input type="text" name="remail" size="50" maxlength="255">
<input type="submit" name="submit" value="Get New Password"></p>
</form>