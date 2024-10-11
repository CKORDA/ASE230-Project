<?php
require_once('functions.php');
if(isset($_SESSION['email'])) die('You are already sign up, logout to create a new account');
$showForm=true;
if(count($_POST)>0) {
    if(isset($_POST['email'][0]) && isset($_POST['password'][0])){
        //process info

        //store into a csv file
        
        $fp=fopen(__DIR__.'/data/users.csv.php','a+');

        fputs($fp, $_POST['email']. ';'.password_hash($_POST['password'],PASSWORD_DEFAULT).PHP_EOL);
        fclose($fp);
        echo 'Your account has been created, proceed to the <a href="signin.php">
        Sign in page</a>.';

        $showForm=false;

    }else echo 'Email and password are missing';
}
if ($showForm){
?>
<h1>signup</h1>
<form method="POST">
    Email<br />
    <input type="email" name="email"
    required /><br /><br />
    Password<br />
    <input type="password" name="password" 
    required/><br /><br />
    <button type="submit">Sign up</button>
</form>
<?php
}
?>