<?php
// Initialize the session
session_start();
 
// Unset all of the session super global variables (array يحمل البيانات في )
// معنى انه عمل تسجيل دخول اي ان السيشن يحمل بيانات اسم المستخدم والرقم السري
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: login.php");
exit;
?>