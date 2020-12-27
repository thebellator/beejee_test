<?php
	mb_internal_encoding("UTF-8");
	require_once "lib/database_class.php";
	require_once "lib/frontpagecontent_class.php";
	require_once "lib/taskscontent_class.php";
	require_once "lib/authcontent_class.php";
	require_once "lib/addtaskcontent_class.php";
	require_once "lib/notfoundcontent_class.php";

	$db = new DataBase();
	$view = $_GET["view"];
	switch ($view) { 
		case "":
			$content = new FrontPageContent($db);
			break;
		case "task":
			$content = new TaskContent($db);
			break;
		case "add_task":
			$content = new AddTaskContent($db);
			break;
	    case "auth":
			$content = new AuthContent($db);
			break;
		case "notfound":
			$content = new NotFoundContent($db);
			break;
		default: $content = new NotFoundContent($db);
		
	}
	echo $content->getContent();
	
?>