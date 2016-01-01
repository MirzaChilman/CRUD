<!--File      	: view_mahasiswa.php
	Nama		: Benaya Nandi Wadhana  / 24010313120047
				  Eggy Reynaldhi		/ 24010313140062
    Deskripsi 	: menampilkan data mahasiswa dan mengupdate data ke database
-->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html401/loose.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<title>Data Mahasiswa</title>
		<link rel="stylesheet" type="text/css" href="style.css"/>
	</head>
	<body>
	<section>
		<h2>Data Mahasiswa</h2>
		<p><a href="add_mhs.php"> Tambah Data Mahasiswa </a></p>
		<table border="1">
			<tr>
			<th>No</th>
			<th>NIM</th>
			<th>Nama</th>
			<th>Jurusan</th>
			<th>Email</th>
			<th>Last Update</th>
			<th>Aksi</th>
			</tr>

		<?php
		// connect database
		require_once('db_login.php');
		$db = new mysqli($db_host, $db_username, $db_password, $db_database);
		if ($db->connect_errno){
			die ("Could not connect to the database: <br />". $db->connect_error);
		}
		//Asign a query
		$query = " SELECT * FROM mahasiswa ORDER BY nim ";
		// Execute the query
		$result = $db->query( $query );
			if (!$result){
				die ("Could not query the database: <br />". $db->error);
			}
		// Fetch and display the results
		$i = 1;
		while ($row = $result->fetch_object()){
			echo '<tr>';
			echo '<td>'.$i.'</td>';$i++;
			echo '<td>'.$row->nim.'</td>';
			echo '<td>'.$row->nama.'</td>';
			echo '<td>'.$row->jurusan.'</td>';
			echo '<td>'.$row->email.'</td>';
			echo '<td>'.$row->last_update.'</td>';
			echo '<td><a href="edit_mhs.php?id='.$row->nim.'"> Ubah </a> | <a href="form_upload.php?nim='.$row->nim.'&nama='.$row->nama.'&jurusan='.$row->jurusan.'"> Unggah </a> | <a href="delete_mhs.php?id='.$row->nim.'"> Hapus</a></td>';
			echo '</tr>';	
		}
		echo '</table>';
		echo '<br />';
		echo 'Total Rows = '.$result->num_rows;
		$result->free();
		$db->close();
		?>
		</table>
		</section>
	</body>
</html>
