<?php
	require_once "lib/database_class.php";
	require_once "lib/manage_class.php";
	
	$db= new DataBase();
	$manage = new Manage($db);
	
	if ($_POST["add_task"]) {
		$r = $manage->addTask();
	}
	elseif ($_POST["auth_form"]) {
		$r = $manage->login();
	}
	elseif ($_POST["completed_task"]) {
		$r = $manage->completedTask();
	}
	elseif ($_POST["edit_task"]) {
		$r = $manage->editTask();
	}
	elseif ($_GET["logout"]) {
		$r = $manage->logout();
	}
    else exit;
    $manage->redirect($r);
?>