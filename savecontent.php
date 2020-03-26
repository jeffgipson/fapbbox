<?php
if ($_POST['content']) {
	session_start(); 
    $_SESSION['content'] = $_POST['content'];
    $_SESSION['mainCss'] = $_POST['mainCss'];
    $_SESSION['sectionCss'] = $_POST['sectionCss'];

	echo 'success';
}
?>