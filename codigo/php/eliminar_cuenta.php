<?php
session_start();

$pdo = new PDO("mysql:host=localhost;dbname=evoclinica", "root", "");

$sql = "DELETE FROM Usuario WHERE Nombre_usuario = :nombre";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    "nombre" => $_SESSION['nombre_usuario']
]);

session_destroy();

header("Location: index.php");
exit;
?>