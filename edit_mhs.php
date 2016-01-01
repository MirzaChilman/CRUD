<?php

$id=$_GET['id'];
//$id = $_GET['id']; 
//connect database
require_once('db_login.php');
$db =new mysqli($db_host, $db_username, $db_password, $db_database);
if ($db->connect_errno){
	die("could not connect to the database: <br />".$db->connect_error);
}

	$error_nim="";
	$error_nama="";
	$error_jenis_kelamin="";
	$error_jurusan="";
	$error_alamat="";
	$error_email="";
	
	$nim ="";
	$nama="";
	$jenis_kelamin="";
	$jurusan="";
	$alamat="";
	$email="";
	$ukm="";

	if(!isset($_POST["submit"])){
		$query = "SELECT * FROM mahasiswa WHERE nim=".$id." ";
		//execute the query
		$result = $db->query( $query );
		if(!$result){
			die("could  not query the database: <br />".$db->error);
		}else{
			while ($row = $result->fetch_object()){
				$nim = $row->nim;;
				$nama = $row->nama;;
				$jenis_kelamin = $row->jenis_kelamin;
				$jurusan = $row->jurusan;;
				$alamat = $row->alamat;;
				$email = $row->email;
				//$ukm = $row->ukm;
			}
		}
	}
	else{
		$nim = $_POST["nim"];
		$nama = $_POST["nama"];
		$jenis_kelamin = $_POST["jenis_kelamin"];
		$jurusan = $_POST["jurusan"];
		$alamat = $_POST["alamat"];
		$email = $_POST["email"];
		
		$nim = test_input($_POST['nim']);
		if ($nim == ''){
		$error_nim = "nim is required";
		$valid_nim = FALSE;
		}
	
		elseif (!preg_match("#([1-9])+(?:-?\d)#",$nim)){
		$error_nim = "Only letters and white space allowed";
		$valid_nim = FALSE;
		}
		
		else{
			$valid_nim = TRUE;
		}
	
		$nama = test_input($_POST['nama']);
		if ($nama == ''){
			$error_nama = "Name is required";
			$valid_nama = FALSE;
		}
		elseif (!preg_match("/^[a-zA-Z ]*$/",$nama)) {
			$error_nama = "Only letters and white space allowed";
			$valid_nama = FALSE;
		}	
		else {
		$valid_nama = TRUE;
		}
	
		$jenis_kelamin = test_input($_POST['jenis_kelamin']);
		if ($jenis_kelamin == ''){
			$error_jenis_kelamin = "Name is required";
			$valid_jenis_kelamin = FALSE;
		}
		else{
			$valid_jenis_kelamin = TRUE;
		}
	
		$jurusan = $_POST['jurusan'];
		if ($jurusan == '' || $jurusan == 'none') {
			$error_jurusan = "jurusan is required";
			$valid_jurusan = FALSE;
		}
		else {
			$valid_jurusan = TRUE;
		}
	
		$alamat = test_input($_POST['alamat']);
		if ($alamat == '') {
			$error_alamat = "Address is required";
			$valid_alamat = FALSE;
		}
		else {
		$valid_alamat = TRUE;
		}
	
		$email = test_input($_POST['email']);
		if($email == '') {
			$error_email = "Email is required";
			$valid_email = FALSE;
		}
		else if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			$error_email = "include xxxxxx@xxxxxx.xxxs";
			$valid_email = FALSE;
		}
		else {
			$valid_email = TRUE;
		}
	
		if (!isset($_POST["ukm"])){
			$ukm = null;
		}else {
			$ukm = $_POST["ukm"];
		}	
	
		//UPDATE DATA INTO DATABASE
		if ($valid_nim && $valid_nama && $valid_jenis_kelamin && $valid_jurusan && $valid_alamat && $valid_email )
		{
			//escape input data
			$nim = $db->real_escape_string($nim);
			$nama = $db->real_escape_string($nama);
			$jenis_kelamin = $db->real_escape_string($jenis_kelamin);
			$jurusan = $db->real_escape_string($jurusan);
			$alamat = $db->real_escape_string($alamat);
			$email = $db->real_escape_string($email);
		
			//assign a query
			$query = "UPDATE mahasiswa SET nim='".$nim."',
			nama='".$nama."',jenis_kelamin='".$jenis_kelamin."', jurusan='".$jurusan."', alamat='".$alamat."', email='".$email."' WHERE
			nim=".$id." ";
			
			$query2 = " DELETE FROM mahasiswa_ukm WHERE nim=".$id." ";
			//execute the query
			$result2 = $db->query( $query2 );
			if(!$result2)
			{
				die("could  not query the database: <br />".$db->error);
			}
			
			$i =0;	
			while($i<sizeof($ukm))
				{
					$query3 = " INSERT INTO mahasiswa_ukm (nim, idukm) VALUES('$nim','".$ukm[$i]."')";
					$result3 = $db->query($query3);
					$i++;
				}
		
			//execute the query
			$result = $db->query( $query );
			if(!$result) {
				die("could not query the database: <br />".$db->error);
			}
			else {
				echo('data has been updated.<br /><br />');
				echo'<a href="index.php">Kembali ke Data Mahasiswa</a>';
				$db->close();
				exit;
			}
		}
	}

	function test_input($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
?>
<!DOCTYPE HTML>
<html>
<head>
	<style>
		.error {color: #FF0000;}
	</style>
</head>
<body>
	<h2>User Input</h2>
	<form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?id='.$id;?>">
	<table>
		<tr>
			<td valign="top">Nim</td>
			<td valign="top">:</td>
			<td valign="top"><input type="text" name="nim" size="30" maxlength="14" placeholder="nim" autofocus
			value="<?php echo $nim;?>"></td>
			<td valign="top"><span class="error">* <?php echo $error_nim;?></span></td>
		</tr>
		<tr>
			<td valign="top">Nama</td>
			<td valign="top">:</td>
			<td valign="top"><input type="text" name="nama" size="30" maxlength="50" placeholder="Name (max 50 characters)" autofocus
			value="<?php echo $nama;?>"></td>
			<td valign="top"><span class="error">* <?php echo $error_nama;?></span></td>
		</tr>
		<tr>
			<td valign="top">Jenis Kelamin</td>
			<td valign="top">:</td>
			<td valign="top">
				<input type="radio" name="jenis_kelamin" value="P" <?php if (isset($jenis_kelamin) && $jenis_kelamin=="P") echo 'selected="true"';?>>P</input>
				<input type="radio" name="jenis_kelamin" value="L" <?php if (isset($jenis_kelamin) && $jenis_kelamin=="L") echo 'selected="true"';?>>L</input>
			<td valign="top"><span class="error">* <?php echo $error_jenis_kelamin;?></span></td>
		</tr>
		<tr>
			<td valign="top">Jurusan</td>
			<td valign="top">:</td>
			<td valign="top">
			<select name="jurusan">
				<option>-Jurusan-</option>
				<?php                                                                      
					$query = "SELECT * FROM jurusan";
					$hasil = $db->query($query);
					if (!hasil) {
						die("could not query the database");
					}else {
						while ($row = $hasil-> fetch_assoc())
						{ 
							echo '<option value="'.$row['nama'].'">' .$row['nama'].'</option>';
						}
					}
				?>
				
			</select></td>
					
			<td valign="top"><span class="error">* <?php echo
			$error_jurusan;?></span></td>
		</tr>
		<tr>
			<td valign="top">Alamat</td>
			<td valign="top">:</td>
			<td valign="top"><textarea name="alamat" rows="5"
			cols="30" maxlength="255" placeholder="alamat (max 255 characters)"><?php echo $alamat;?></textarea></td>
			<td valign="top"><span class="error">* <?php echo $error_alamat;?></span></td>
		</tr>
		<!--tambah email-->
		<tr>
			<td valign="top">Email</td>
			<td valign="top">:</td>
			<td valign="top"><input type="email" name="email" size="30"
			 placeholder="Your Email" autofocus value="<?php echo $email;?>"></td>
			<td valign="top"><span class="error">*<?php if (!empty($error_email))echo $error_email;?></span></td>
		</tr>
		<tr>
			<td valign="top">UKM</td>
			<td valign="top">:</td>
			<td valign="top">
				<?php                                                                      
					$query = "SELECT * FROM ukm";
					$hasil= $db->query($query);
					while ($row = $hasil-> fetch_assoc()) {
						echo '<input type="checkbox" name="ukm[]" value="'.$row['idukm'].'">'.$row['nama'].'</br>';
					}
				?>			
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="3"><br><input type="submit" name="submit" value="Submit">
		</tr>
	</table>
	</form>
</body>
</html>