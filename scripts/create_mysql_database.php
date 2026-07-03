<?php

declare(strict_types=1);

$envPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';

if (! file_exists($envPath)) {
    fwrite(STDERR, ".env file not found. Copy .env.example to .env first.\n");
    exit(1);
}

$env = parse_ini_file($envPath, false, INI_SCANNER_RAW);

if ($env === false) {
    fwrite(STDERR, "Could not read .env file.\n");
    exit(1);
}

$connection = $env['DB_CONNECTION'] ?? 'mysql';

if ($connection !== 'mysql') {
    fwrite(STDOUT, "DB_CONNECTION is {$connection}; skipping MySQL database creation.\n");
    exit(0);
}

$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$database = $env['DB_DATABASE'] ?? '';
$username = $env['DB_USERNAME'] ?? 'root';
$password = $env['DB_PASSWORD'] ?? '';

if ($database === '') {
    fwrite(STDERR, "DB_DATABASE is not set in .env.\n");
    exit(1);
}

try {
    $pdo = new PDO("mysql:host={$host};port={$port};charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $quotedDatabase = str_replace('`', '``', $database);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$quotedDatabase}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    fwrite(STDOUT, "Database {$database} is ready.\n");
} catch (Throwable $exception) {
    fwrite(STDERR, "Could not create database {$database}: {$exception->getMessage()}\n");
    exit(1);
}
