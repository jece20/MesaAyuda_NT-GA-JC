<?php
// Iniciar sesión para mantener datos de usuario en toda la app
session_start();

// Credenciales de conexión a Clever Cloud
$host = 'baw80isr9j2sjcoo0rjf-mysql.services.clever-cloud.com';
$dbname = 'baw80isr9j2sjcoo0rjf';
$username = 'uw4pwochar86koz1';
$password = 'l681IFK7ZEr64vTahr7A';

// Puertos comunes de MySQL (Clever Cloud usa el 3306)
$puerto = 3306;
$puerto_alternativo = 3307;

try {
    // Intentar la conexión con el puerto principal
    $pdo = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$dbname;charset=utf8",
        $username,
        $password
    );
    // Configurar opciones seguras y consistentes de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Si falla el puerto principal, intenta el alternativo
    try {
        $pdo = new PDO(
            "mysql:host=$host;port=$puerto_alternativo;dbname=$dbname;charset=utf8",
            $username,
            $password
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e2) {
        die("❌ Error de conexión: No se pudo conectar a MySQL en los puertos $puerto o $puerto_alternativo. " . $e2->getMessage());
    }
}

/**
 * Verifica si el usuario ha iniciado sesión.
 * Si no, redirige al login.
 */
function verificarLogin() {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit();
    }
}

/**
 * Verifica si el usuario tiene un rol específico.
 * Si no coincide, lo devuelve al dashboard general.
 */
function verificarRol($rol) {
    verificarLogin();
    if ($_SESSION['rol'] !== $rol) {
        header('Location: dashboard.php');
        exit();
    }
}
?>
