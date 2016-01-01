<?php
include('db_login.php'); 
$nim = $_REQUEST['nim'];

if (!file_exists("uploads/$nim")) {
    mkdir("uploads/$nim", 0777, true);
}

$target_dir = "uploads/$nim/";
$target_file = $target_dir . "ktm_$nim.jpg";
$file_ktm = "ktm_$nim.jpg";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File adalah sebuah gambar - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File bukan sebuah gambar";
        $uploadOk = 0;
    }

	// Check if file already exists
	if (file_exists($target_file)) {
	    unlink($target_file);
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 200000) {
	    echo "Maaf, file terlalu besar";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg") {
	    echo "Harap masukkan file dengan format JPG";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Maaf, file tidak terunggah";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	    	$sql = "UPDATE `mahasiswa` SET  `scan_ktm` =  '$file_ktm' WHERE nim=$nim"; 
			mysqli_query($conn,$sql) or die(mysqli_error()); 
	        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}

}


?>

<!DOCTYPE html>
<html>
<body>

<form action="unggah_ktm.php?nim=<?=$nim?>" method="post" enctype="multipart/form-data">
    Pilih Foto Untuk diupload :
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>



