<?
session_start();


$db = include __DIR__.'/../database/start.php';

$comments = $db->getAllCommentsWithNames();

include __DIR__.'/../index.view.php';

?>
