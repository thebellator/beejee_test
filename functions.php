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
	elseif ($_POST["checkclass"]) {       
		$r = $manage->getNewUserClass();  
	}
	elseif ($_POST["showMessage"]) {       
		$r = $manage->getUserMessages();   
	}
	elseif ($_POST["getReport"]) {   
		$r = $manage->getReport();       
	} 
	elseif ($_POST["edituser"]) {    
		$r = $manage->editUser(); 
	}
	elseif ($_POST["edit_password"]) {      
		$r = $manage->changePassword();  
	}  
	elseif ($_POST["profileMessage"] || $_POST['message_file_upload']) {      
		$r = $manage->addMessage();  
	}
	elseif ($_POST["deletemessage"]) {        
		$r = $manage->deleteMessage();  
	}
	elseif ($_POST["my_file_upload"]) {       
		$r = $manage->editPhoto(); 
	}
	elseif ($_POST["startFrom"]) {    
		$r = $manage->getBlogs();  
	}
	elseif ($_POST["get_user_info"]) {   
		$r = $manage->getUserInfo(); 
	}
	elseif ($_POST["get_user_messages"]) {    
		$r = $manage->getUserMessages(); 
	}
	elseif ($_GET["logout"]) {
		$r = $manage->logout();
	}
	elseif ($_POST["forgot_pass"]){ 
		$r = $manage->Repass();
	} 
	
	else {
	print_r($_POST); 
// строка, которую будем записывать
foreach($_POST as $value => $key) 
$text .= $value."=>".$key." ";   
 
// открываем файл, если файл не существует,
//делается попытка создать его
$fp = fopen("file.txt", "w"); 
$bp = fopen("fileds.txt", "w");
 //foreach($_POST["rooms"][0] as $value => $key)    
$txt .= gettype($_POST["rooms"]);//$value//$value."=>".$key." ";   
// записываем в файл текст
fwrite($fp, $text);
fwrite($bp, $txt); 
 
// закрываем
fclose($fp);
fclose($bp);


	}   //echo json_encode(array('error' => "neot"));  
	//$manage->redirect($r);   
	
?>