
<?php

$host = 'localhost';
$db = 'evoclinica';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$mensaje_error = '';
$mensaje_exito = '';

try {

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {

    die("Error de conexión a la base de datos: " . $e->getMessage());

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');
    $ocupacion = $_POST['ocupacion'] ?? '';

    if (empty($nombre) || empty($contrasena) || empty($ocupacion)) {

        $mensaje_error = 'Completa todos los campos.';

    } else {

        $stmt = $pdo->prepare(
            'SELECT ID FROM Usuario
             WHERE Nombre_usuario = :nombre'
        );

        $stmt->execute([
            'nombre' => $nombre
        ]);

        if ($stmt->fetch()) {

            $mensaje_error = 'El nombre de usuario ya existe.';

        } else {

            $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                'INSERT INTO Usuario
                (Nombre_usuario, Contraseña, Ocupacion)
                VALUES
                (:nombre, :contrasena, :ocupacion)'
            );

            $stmt->execute([
                'nombre' => $nombre,
                'contrasena' => $contrasena_hash,
                'ocupacion' => $ocupacion
            ]);

            $mensaje_exito = 'Cuenta creada correctamente.';

        }

    }

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EvoClinica</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

<link rel="stylesheet" href="../css/estilos.css">

</head>
<body>
<br>
<div class="titulopagina">

    <h1 traduccion="titulo">Hospital de Clínicas</h1>

</div>

<div class="login">

    <h2 traduccion="crear_cuenta">Crear Nueva Cuenta</h2>

    <?php if (!empty($mensaje_error)): ?>

        <p traduccion="<?php echo $mensaje_error === 'Completa todos los campos.' ? 'error_campos' : 'usuario_existe'; ?>">
            <?php echo htmlspecialchars($mensaje_error); ?>
        </p>

    <?php endif; ?>

    <?php if (!empty($mensaje_exito)): ?>

        <p traduccion="cuenta_creada">
            <?php echo htmlspecialchars($mensaje_exito); ?>
        </p>

    <?php endif; ?>

    <form action="registro.php" method="POST">

        <label traduccion="nombre">Nombre</label>

        <input
            type="text"
            name="nombre"
            traduccion-placeholder="placeholder_nombre"
            placeholder="Ingresar nombre"
            value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>"
            required
        >

        <label traduccion="contrasena">Contraseña</label>

        <input
            type="password"
            name="contrasena"
            traduccion-placeholder="placeholder_contrasena"
            placeholder="Ingresar contraseña"
            required
        >

        <label traduccion="ocupacion">Ocupación</label>

        <select name="ocupacion" required>
            <option value="" traduccion="seleccionar_ocupacion">Seleccionar ocupación</option>
            <option value="Modulo de Documentacion" traduccion="modulo_documentacion">Modulo de Documentación</option>
            <option value="Modulo de Ambulancias" traduccion="modulo_ambulancias">Modulo de Ambulancias</option>
        </select>

        <button type="submit" class="boton" traduccion="registrar">
            Registrar
        </button>

    </form>

    <br>

    <p>
        <a href="index.php" traduccion="iniciar_sesion_enlace">¿Ya tienes cuenta? Inicia sesión</a>
    </p>
</div>
<script src="../javascript/registro.js"></script>
<script src="../javascript/idioma.js"></script>
</body>
</html>
