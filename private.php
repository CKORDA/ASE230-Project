<?php

require_once('functions.php');
if(!isset($_SESSION['email'])) die('This is a private page you are not 
allowed here.')

?>
<p><a href="index.php">Go back to the login page</a></p>
<h1>Private</h1>
<?=$_SESSION['email'] ?><br />

