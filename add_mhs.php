<!--File      	: add_mahasiswa.php
	Nama		: Benaya Nandi Wadhana  / 24010313120047
				  Eggy Reynaldhi		/ 24010313140062
    Deskripsi 	: membuat data mahasiswa dan mengupdate data ke database
-->

<?php
	//connect database
	require_once('db_login.php');
	$db = new mysqli($db_host, $db_username, $db_password, $db_database);
	
	if($db->connect_errno){
		die ("could not connect to the database : <br/>". $db->connect_error);
	}
		
	$valid_nim=0;	
	if(isset($_POST["submit"])){
		$nim = test_input($_POST['nim']);
		if ($nim == ''){
			$error_nim = "harap isi dengan NIM";
			$valid_nim = FALSE;
		}elseif (!preg_match("/^[0-9]*$/",$nim)){	//preg_match buat regexp
			$error_nim = "Isi dengan 14 karakter angka";
			$valid_nim = FALSE;
		}else{
			$valid_nim = TRUE;
		}


	$valid_nama=0;	
	if(isset($_POST["submit"])){
		$nama = test_input($_POST['nama']);
		if ($nama == ''){
			$error_nama = "Nama harus diisi";
			$valid_nama = FALSE;
		}elseif (!preg_match("/^[a-zA-Z ]*$/",$nama)){	//preg_match buat regexp
			$error_nama = "isi dengan huruf dan spasi";
			$valid_nama = FALSE;
		}else{
			$valid_nama = TRUE;
		}
		
		$jenkel = test_input($_POST['jenkel']);
		if ($jenkel == null){
			$error_jenkel = "Jenis kelamin tidak boleh dikosongkan";
			$valid_jenkel = FALSE;
		}else{
			$valid_jenkel = TRUE;
		}
		
		$jurusan = test_input($_POST['jurusan']);
		if ($jurusan == 'none'){
			$error_jurusan = "Jurusan tidak boleh dikosongkan";
			$valid_jurusan = FALSE;
		}else{
			$valid_jurusan = TRUE;
		}
		
		$alamat = test_input($_POST['alamat']);
		if ($alamat == ''){
			$error_alamat = "Alamat tidak boleh dikosongkan";
			$valid_alamat = FALSE;
		}else{
			$valid_alamat = TRUE;
		}
		
		$email = test_input($_POST['email']);
		if ($email == ''){
			$error_email = "Email tidak boleh dikosongkan";
			$valid_email = FALSE;
		}else{
			$valid_email = TRUE;
		}
		
		
		if (!isset($_POST["ukm"])){
			$ukm = 0;
		}else {
			$ukm = $_POST["ukm"];
		}
	}
	
	//insert data into database
	if($valid_nim && $valid_nama && $valid_jenkel && $valid_jurusan && $valid_alamat && $valid_email){

		//escape inputs data
		$nim = $db->real_escape_string($nim);
		$nama = $db->real_escape_string($nama);
		$jenkel = $db->real_escape_string($jenkel);
		$jurusan = $db->real_escape_string($jurusan);
		$alamat = $db->real_escape_string($alamat);
		$email = $db->real_escape_string($email);
		
		//assign a query
		$query = " INSERT INTO mahasiswa (nim, nama, jenis_kelamin, jurusan, alamat,email,last_update) VALUES('$nim','$nama','$jenkel','$jurusan', '$alamat', '$email','".date("Y-m-d h:i:s",time()+3600*7)."')";
		$i = 0;
		if ($ukm != 0){
			while($i<sizeof($ukm))
			{
				$query2 = " INSERT INTO mahasiswa_ukm (nim, idukm) VALUES('$nim','".$ukm[$i]."')";
				$result2 = $db->query($query2);
				$i++;
			}
		}
			
		//execute the query
		$result = $db->query($query);
		if (!$result){
			die("could not query the database: <br />".$db->error);
		}else{
			echo '<h2>Success!</h2>';
			echo '<br>Data sudah berhasil diperbarui!<br /><br />';
			echo '<a href="view_mahasiswa.php"> Kembali ke Data Mahasiswa </a>';
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

<html>
	<head>
		<style>
			.error {color: #FF0000;}
		</style>
	</head>
	
	<body> 
		<h2>User Input</h2>
		<form method="POST" autocomplete="on" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<table>
			<tr>
				<td valign="nim">NIM</td>
				<td valign="top">:</td>
				<td valign="top"><input type="text" name="nim" size="30" maxlength="14" placeholder="maks 14 karakter"></td>
				<td valign="top"><span class="error">*<?php if(!empty($error_nim)) echo $error_nim;?></span></td>
			</tr>
			<tr>
				<td valign="Name">Nama</td>
				<td valign="top">:</td>
				<td valign="top"><input type="text" name="nama" size="30" maxlength="30" placeholder="maks 30 karakter"></td>
				<td valign="top"><span class="error">*<?php if(!empty($error_name)) echo $error_name;?></span></td>
			</tr>
			<tr>
				<td valign="Name">Jenis Kelamin</td>
				<td valign="top">:</td>
				<td valign="top"><input type="radio" name="jenkel" value="L">Laki - laki <br>
								<input type="radio" name="jenkel" value="P">Perempuan</td>
				<td valign="top"><span class="error">*<?php if(!empty($error_jenkel)) echo $error_jenkel;?></span></td>
			</tr>
			<tr>
				<td valign="top">Jurusan</td>
				<td valign="top">:</td>
				<td valign="top">
					<select name='jurusan'>
					<option value='none'>-- Pilih Jurusan --</option>
					
					<?php
					$query = "SELECT * from jurusan";
					
					//execute the query
					$result = $db->query($query);
					if(!$result){
						die("Could not query the database: <br />".$db->error);
					}else{
						while ($row = $result->fetch_assoc()){
							$id = $row['idjurusan'];
							$nama = $row['nama'];
							echo '<option value="'.$nama.'">'.$nama.'</option>';
						}
					}
					?>	
			</select>
			</td>
			<td valign="top"><span class="error">*<?php if(!empty($error_jurusan)) echo $error_jurusan;?></span></td>
		</tr>
		<tr>
			<td valign="Email">Email</td>
			<td valign="top">:</td>
			<td valign="top"><input type="email" name="email" size="30" maxlength="50" placeholder="xxx@yahoo.com"></td>
			<td valign="top"><span class="error">*<?php if(!empty($error_email)) echo $error_email;?></span></td>
		</tr>
		<tr>
			<td valign="top">Alamat</td>
			<td valign="top">:</td>
			<td valign="top"><textarea name="alamat" rows="5" cols="30" maxlength="255" placeholder="Alamat (maks 255 karakter)" ></textarea></td>
			<td valign="top"><span class="error">*<?php if(!empty($error_alamat)) echo $error_alamat;?></span></td>
		</tr>
		<tr>
			<td valign="top">UKM</td>
			<td valign="top">:</td>
			<td valign="top">
			<?php
				$query = "SELECT * from ukm";
				
				//execute the query
				$result = $db->query($query);
				if(!$result){
					die("Could not query the datbase: <br />".$db->error);
				}else{
					while ($row = $result->fetch_assoc()){
						$id = $row['idukm'];
						$nama = $row['nama'];
						echo '<input type="checkbox" name="ukm[]" value="'.$id.'">'.$nama.' <br>';
					}
				}
			?>
			</td>
			<td valign="top"><span class="error"><?php if(!empty($error_ukm)) echo $error_ukm;?></span></td>
		</tr>
		<tr>
			<td valign="top" colspan="3"><br><input type="submit" name="submit" value="Submit">&nbsp; 
			<input type="reset" name="reset" value="Reset"></td>
		</tr>
	</table>
</form>
</body>
</html>