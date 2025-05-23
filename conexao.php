<?php
/*
$host = 'sql108.infinityfree.com';
$usuario = 'if0_39046784';
$senha = 'Dpa131474';
$banco = 'if0_39046784_salao';
*/
$host= 'localhost';
$usuario = 'root';
$senha = '1234';
$banco = 'salao';

$conn = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
?>