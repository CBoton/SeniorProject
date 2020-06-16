<?php


require("../../auth/login_check.php"); //Make sure the users is logged in
require_once('../../../variables.php');

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    $status->result = "ERROR";
    $status->message = "Sorry, you don't have permission to do that.";
    die(json_encode($status));
}

if ( !isset($_FILES['file']) ) {
    $status->result = "ERROR";
    $status->message = "Invalid parameters.";
    die(json_encode($status));
}

try {

    if(empty($_FILES["file"]["name"])) {
        $status->result = "ERROR";
        $status->message = "Invalid parameters.";
        die(json_encode($status));
    }

    $uploadPath = '../../../res/imgs/';

    // File info
    $fileName = basename($_FILES["file"]["name"]);
    $imageUploadPath = $uploadPath . $fileName;
    $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg');
    if(!in_array($fileType, $allowTypes)){
        $status->result = "ERROR";
        $status->message = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
        die(json_encode($status));
    }
    // Image temp source
    $imageTemp = $_FILES["file"]["tmp_name"];

    //New Name Path
    $newFileName = generateRandomString() . "." . $fileType;
    $newPath = $uploadPath . $newFileName;

    // Compress size and upload image
    $compressedImage = compressImage($imageTemp, $newPath, 75);

    if($compressedImage){
        $status->result = "SUCCESS";
        $status->message = "Image uploaded.";
        $status->file_name = $newFileName;
        die(json_encode($status));
    }else{
        $status->result = "ERROR";
        $status->message = "Image compression failed.";
        die(json_encode($status));
    }

} catch (PDOException $e) {
    $status->result = "ERROR";
    $status->message = "Something went wrong. Please try again later.";
    die(json_encode($status));
}





function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function compressImage($source, $destination, $quality) {
    // Get image info
    $imgInfo = getimagesize($source);
    $mime = $imgInfo['mime'];

    // Create a new image from file
    switch($mime){
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($source);
            break;
        default:
            $image = imagecreatefromjpeg($source);
    }

    // Save image
    imagejpeg($image, $destination, $quality);

    // Return compressed image
    return $destination;
}








?>