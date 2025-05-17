<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Nagan\BrilloeternoDbSetup\ConsoleColor;
use Nagan\BrilloeternoDbSetup\Output;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST'] ?? 'localhost';
$username = $_ENV['DB_USERNAME'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? '';
$dbname = $_ENV['DB_DATABASE'] ?? 'brilloeterno';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $seedsDir = __DIR__ . '/../seeds';
    $files = glob($seedsDir . '/*.sql');

    foreach ($files as $file) {
        echo Output::color("Ejecutando seed: $file\n", ConsoleColor::BLUE);
        $sql = file_get_contents($file);
        try {
            $pdo->exec($sql);
            echo Output::color("Seed completado: $file\n", ConsoleColor::GREEN);
        } catch (PDOException $e) {
            echo Output::color("Error en el seed $file: " . $e->getMessage() . "\n", ConsoleColor::RED);
        }
    }
} catch (PDOException $e) {
   echo Output::color("Error al ejecutar seeds: " . $e->getMessage() . "\n", ConsoleColor::RED);
}