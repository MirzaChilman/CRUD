<!--File		: form_upload.html
    Deskripsi	: menampilkan form upload
-->

<?php
include('db_login.php'); 
$nim = $_GET['nim'];

if (isset($_POST['submitted'])) { 

}

$query = mysqli_query($conn,"SELECT * FROM mahasiswa WHERE nim=$nim");
$result = mysqli_fetch_array($query);

$sudahFoto = $result['foto'] != null; 
$sudahKTM = $result['scan_ktm'] != null;

if ($sudahFoto){
	$foto = $result['foto'] ;
	$aksiFoto = "<a href='unggah_foto.php?nim=$nim'>Ubah</a>|<a href='hapus_foto.php?nim=$nim'>Hapus</a>";
}else{
	$foto = "Belum diunggah";
	$aksiFoto = "<a href='unggah_foto.php?nim=$nim'>Unggah</a>";
}

if ($sudahKTM){
	$ktm = $result['scan_ktm'];
	$aksiKTM = "<a href='unggah_ktm.php?nim=$nim'>Ubah</a>|<a href='hapus_ktm.php?nim=$nim'>Hapus</a>";
}else{
	$ktm = "Belum diunggah";
	$aksiKTM = "<a href='unggah_ktm.php?nim=$nim'>Unggah</a>";
}

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>
		NIM : <?=$result['nim']?> <br/>
		Nama : <?=$result['nama']?> <br/>
		Jurusan : <?=$result['jurusan']?> <br/>
	</p>
	<table>
		<tr>
			<td>
				Jenis Berkas
			</td>
			<td>
				Berkas
			</td>
			<td>
				Aksi
			</td>
		</tr>
		<tr>
			<td>
				Foto
			</td>
			<td>
				<?=$foto?>
			</td>
			<td>
				<?=$aksiFoto?>
			</td>
		</tr>
		<tr>
			<td>
				Scan KTM
			</td>
			<td>
				<?=$ktm?>
			</td>
			<td>
				<?=$aksiKTM?>
			</td>
		</tr>
	</table>
</body>
</html>

