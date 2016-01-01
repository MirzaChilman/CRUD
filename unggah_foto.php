<?php
include('db_login.php'); 
$nim = $_REQUEST['nim'];

if (!file_exists("uploads/$nim")) {
    mkdir("uploads/$nim", 0777, true);
}

$target_dir = "uploads/$nim/";
$target_file = $target_dir . "foto_$nim.jpg";
$file_foto = "foto_$nim.jpg";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File adalah sebuah gambar - " . $check["mime"] . ".";
		echo "<br/>";
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
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg") {
	    echo "Sorry, only JPG  files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	    	$sql = "UPDATE `mahasiswa` SET  `foto` =  '$file_foto' WHERE nim=$nim"; 
			mysqli_query($conn,$sql) or die(mysqli_error()); 
	        echo "File ". basename( $_FILES["fileToUpload"]["name"]). " Berhasil di unggah.<br/>";
			echo '<a href="index.php">Kembali ke Data Mahasiswa</a>';
	    } else {
	        echo "Sorry, there was an error uploading your file.";
	    }
	}

}


?>

<!DOCTYPE html>
<html>
<body>

<form action="unggah_foto.php?nim=<?=$nim?>" method="post" enctype="multipart/form-data">
    Pilih Foto Untuk diupload :
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>



