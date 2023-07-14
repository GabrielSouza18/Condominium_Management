<?php

$host = "localhost";
$username = "root";
$password = "";
$db = "condominio";

$PicNum = $_GET["PicNum"];

$connect = mysqli_connect($host, $username, $password, $db) or die("Impossível Conectar");
$result = mysqli_query($connect, "SELECT * FROM usuario WHERE usu_id = $PicNum") or die("Impossível executar a query ");

$row = mysqli_fetch_object($result);
Header("Content-type: image/gif");
echo $row->usu_foto;
