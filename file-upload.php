<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST, GET, PUT, DELETE, UPDATE");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);
	
$fileName  =  $_FILES['sendfile']['name'];
$tempPath  =  $_FILES['sendfile']['tmp_name'];
$fileSize  =  $_FILES['sendfile']['size'];
		
if(empty($fileName))
{
	$errorMSG = json_encode(array("message" => "Please select a file", "status" => false));
	echo $errorMSG;	
}
else
{
	$upload_path = 'file/'; 
	
	$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		
	$file_extensions = array('doc', 'docs', 'html', 'htm', 'odt', 'pdf', 'ppt', 'pptx', 'txt', 'rar', 'zip'); 				

	if(in_array($fileExt, $file_extensions))
	{				
		if(!file_exists($upload_path . $fileName))
		{
			if($fileSize < 10000000){
				move_uploaded_file($tempPath, $upload_path . $fileName);
			}
			else
			{		
				$errorMSG = json_encode(array("message" => "File is too large, should be less than 10 MB", "status" => false));	
				echo $errorMSG;
			}
		}
		else
		{
			// $errorMSG = json_encode(array("message" => "Sorry, file already exists check upload folder", "status" => false));	
			// echo $errorMSG;
		}
	}
	else
	{		
		$errorMSG = json_encode(array("message" => "Unsupported file format", "status" => false));	
		echo $errorMSG;		
	}
}
		
if(!isset($errorMSG))
{		
	echo json_encode(array("message" => "File Uploaded Successfully", "status" => true));	
}

?>