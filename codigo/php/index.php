<?php

session_start();

$host = 'localhost';
$db = 'evoclinica';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$mensaje_error = '';

try {

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {

    die("Error de conexión a la base de datos: " . $e->getMessage());

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');

    if (empty($nombre) || empty($contrasena)) {

        $mensaje_error = 'Completa todos los campos.';

    } else {

        $stmt = $pdo->prepare(
            'SELECT * FROM Usuario WHERE Nombre_usuario = :nombre'
        );

        $stmt->execute([
            'nombre' => $nombre
        ]);

        $usuario = $stmt->fetch();

        if ($usuario) {

            if (password_verify($contrasena, $usuario['Contraseña'])) {

$_SESSION['usuario_id'] = $usuario['ID'];
$_SESSION['nombre_usuario'] = $usuario['Nombre_usuario'];
$_SESSION['ocupacion'] = $usuario['Ocupacion'];

                header('Location: modulos.html');
                exit;

            } else {

                $mensaje_error = 'Usuario o contraseña incorrectos.';

            }

        } else {

            $mensaje_error = 'Usuario o contraseña incorrectos.';

        }

    }

}

?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <title>EvoClínica</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/estilos.css">

</head>

<body>

<br>

<div class="titulopagina">

    <h1>Hospital de Clínicas</h1>

</div>

<div class="login">

    <h2>Iniciar Sesión</h2>

    <?php if (!empty($mensaje_error)): ?>

        <p>
            <?php echo htmlspecialchars($mensaje_error); ?>
        </p>

    <?php endif; ?>

    <form action="index.php" method="POST">

        <label>Usuario</label>

        <input
            type="text"
            name="nombre"
            placeholder="Ingresar nombre de usuario"
            required
        >

        <label>Contraseña</label>

        <input
            type="password"
            name="contrasena"
            placeholder="Ingresar contraseña"
            required
        >

        <button type="submit" class="boton">
            Ingresar
        </button>

        <br>

        <p>
            <a href="registro.php">¿No tienes una cuenta? Registrate</a>
        </p>

    </form>
</div>
</body>
</html>
