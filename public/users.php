<?php
/**
 * Users Controller
 * 
 * @version 1.0 
 * 
 */

if(isset($_GET['action']))
	$action=$_GET['action'];
else 
	$action = 'select';


// Read config
$config=parse_ini_file('../application/configs/config.ini',true);



// Include Gateways
include_once('../application/models/dataGatewayFiles.php');

// Include Models
include_once('../application/models/files/functions.php');
include_once('../application/models/files/filesFunctions.php');
include_once('../application/models/users/usersFunctions.php');




switch ($action)
{
	case 'insert':
		if($_POST)
		{						
			$name=insertPhoto($uploadDir);
			$_POST[]=$name;			
			writeDataToFile ($userFilename, $_POST);			
			header('Location: /users.php');
			exit;
		}
		else
		{
			include_once('../application/views/forms/user.php');
		}
	break;
	
	case 'update':
		if($_POST)
		{
			$user=readUser($id, $config);
			$name=updatePhoto($user[11], $uploadDir);			
			$_POST[]=$name;
			$dataArray[$_POST['id']]=$_POST;			
			writeDataToFile($userFilename, $dataArray, TRUE);			
			header('Location: /users.php');
			exit;
		}
		else 
		{
			$user=readUser($_GET['id'], $config);
			$pets=commaToArray($user[8]);
			$sports=commaToArray($user[9]);		
			include_once('../application/views/forms/user.php');
		}
	break;
	
	case 'delete':
		if($_POST)
		{
			if($_POST['submit']=='Si')
			{		
				$user=readUser($id, $config);
				deleteFile($user[11], $uploadDir);			
				unset($dataArray[$_POST['id']]);
				writeDataToFile($userFilename, $dataArray, TRUE);
			}
			header('Location: /users.php');
			exit;
		}
		else 
		{
			$user=readUser($_GET['id'], $config);
			include_once('../application/views/users/delete.php');
		}
	break;
		
	case 'select':
		$users=readUsers($config);
		include_once ('../application/views/users/select.php');
	break;	
	
	default:
		echo "Esto default";
	break;
	
}

