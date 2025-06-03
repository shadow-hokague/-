<?php
$host = 'mysql-alaye.alwaysdata.net';
$user = 'alaye';
$pass = '@Motdepasse0000';
$db = 'alaye_db';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "Connexion réussie";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
