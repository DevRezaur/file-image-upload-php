<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST, GET, PUT, DELETE, UPDATE");
header("Acess-Control-Allow-Headers: Acess-Control-Allow-Headers, Content-Type, Acess-Control-Allow-Methods, Authorization");

$data = json_decode(file_get_contents("php://input"), true);
	
$fileName  =  $_FILES['sendimage']['name'];
$tempPath  =  $_FILES['sendimage']['tmp_name'];
$fileSize  =  $_FILES['sendimage']['size'];
		
if(empty($fileName))
{
	$errorMSG = json_encode(array("message" => "Please select image", "status" => false));
	echo $errorMSG;	
}
else
{
	$upload_path = 'image/'; 
	
	$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
		
	$image_extensions = array('jpeg', 'jpg', 'png', 'gif'); 				

	if(in_array($fileExt, $image_extensions))
	{				
		if(!file_exists($upload_path . $fileName))
		{
			if($fileSize < 10000000){
				move_uploaded_file($tempPath, $upload_path . $fileName);
			}
			else
			{		
				$errorMSG = json_encode(array("message" => "Image is too large, should be less than 10 MB", "status" => false));	
				echo $errorMSG;
			}
		}
		else
		{
			// $errorMSG = json_encode(array("message" => "Sorry, image already exists check upload folder", "status" => false));	
			// echo $errorMSG;
		}
	}
	else
	{		
		$errorMSG = json_encode(array("message" => "Only JPG, JPEG, PNG & GIF allowed", "status" => false));	
		echo $errorMSG;		
	}
}
		
if(!isset($errorMSG))
{		
	echo json_encode(array("message" => "Image Uploaded Successfully", "status" => true));	
}

?>