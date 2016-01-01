<?php

$id=$_GET['nim'];

require_once('db_login.php');
$db =new mysqli($db_host, $db_username, $db_password, $db_database);

if ($db->connect_errno)
{
	die("could not connect to the database: <br />".$db->connect_error);
}
	$query1 = " SELECT foto FROM mahasiswa WHERE nim=".$id."";
	//execute the query
	$result1 = $db->query( $query1 );
	if(!$result1)
	{
		die("could  not query the database: <br />".$db->error);
	}
	else
	{
		$row=$result1->fetch_object();
		unlink("uploads/$id/".$row->foto);
		
	}
	
	$query2 = " UPDATE mahasiswa SET foto = null WHERE nim=".$id."";
	//execute the query
	$result2 = $db->query( $query2 );
	if(!$result2)
	{
		die("could  not query the database: <br />".$db->error);
	}
	else
	{
		echo '<a href="index.php">Kembali ke Data Mahasiswa</a>';
		$db->close();
		exit;
	}
?>