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

    $pdo = new PDO($dsn, $user, $pass);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        if (!$nombre || !$contrasena) {

            $mensaje_error = 'Completa todos los campos.';

        } else {

            $sql = "SELECT * FROM Usuario WHERE Nombre_usuario = ?";

            $consulta = $pdo->prepare($sql);
            $consulta->execute([$nombre]);

            $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {

                if (password_verify($contrasena, $usuario['Contraseña'])) {

                    $_SESSION['usuario_id'] = $usuario['ID'];
                    $_SESSION['nombre_usuario'] = $usuario['Nombre_usuario'];
                    $_SESSION['ocupacion'] = $usuario['Ocupacion'];

                    header('Location: ../html/modulos.html');
                    exit;

                } else {

                    $mensaje_error = 'Usuario o contraseña incorrectos.';

                }

            } else {

                $mensaje_error = 'Usuario o contraseña incorrectos.';

            }
        }
    }

} catch (PDOException $e) {

    die("Error de conexión a la base de datos: " . $e->getMessage());

}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>EvoClinica</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/estilos.css">

</head>

<body>

<br>

<div class="idiomas">
    <button type="button" onclick="cambiarIdioma('es')">Español</button>
    <button type="button" onclick="cambiarIdioma('en')">English</button>
</div>

<div class="titulopagina">

    <h1 traduccion="titulo">Hospital de Clínicas</h1>

</div>

<div class="login">

    <h2 traduccion="iniciar_sesion">Iniciar Sesión</h2>

    <?php if (!empty($mensaje_error)) { ?>

        <p traduccion="<?php
            echo $mensaje_error === 'Completa todos los campos.'
                ? 'error_campos'
                : 'error_login';
        ?>"><?php echo htmlspecialchars($mensaje_error); ?></p>

    <?php } ?>

    <form action="index.php" method="POST">

        <label traduccion="usuario">Usuario</label>

        <input

            type="text"
            name="nombre"
            traduccion-placeholder="placeholder_usuario"
            placeholder="Ingresar nombre de usuario"
            required>

        <label traduccion="contrasena">Contraseña</label>

        <input

            type="password"
            name="contrasena"
            traduccion-placeholder="placeholder_contrasena"
            placeholder="Ingresar contraseña"
            required>

        <button type="submit" class="boton" traduccion="ingresar">
            Ingresar
        </button>

        <br>

        <p>
            <a href="../php/registro.php" traduccion="registro">
                ¿No tienes una cuenta? Registrate
            </a>
        </p>

    </form>
    
</div>
    <script src="../javascript/idioma.js">
</script>
</body>
</html>