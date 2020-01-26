<? 
session_start(); 
include 'functions.php';
$db = include 'database/start.php';

$comments = $db->getAllCommentsWithNames();

include 'admin.view.php';
?>



