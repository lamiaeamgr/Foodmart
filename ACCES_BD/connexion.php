<?php
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    die('Erreur : Le fichier .env est introuvable.');
}

$env = parse_ini_file($envFile);
$serveur = $env['Serveur'] ?? 'localhost';
$utilisateur = $env['Utilisateur'] ?? 'root';
$password = $env['Password'] ?? '';
$db_name = $env['db_name'] ?? 'gestion_magasin';

$conn = mysqli_connect($serveur, $utilisateur, $password, $db_name);
if (!$conn) {
    die('Erreur de connexion : ' . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8');
?>

