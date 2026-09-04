<?php
session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: index.php");
    exit;
}

$nombre = $_SESSION['nombre_usuario'];
$ocupacion = $_SESSION['ocupacion'];

if ($ocupacion == "Modulo de Ambulancias") {
    $emoji = "🚑";
} else {
    $emoji = "📄";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Cuenta</title>

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

    <div class="flex">

        <div class="logo">
            <img src="../imagenes/logo.png">
        </div>

        <div class="contenedor">

            <section class="caja">
                <h2><a href="../html/modulos.html">Modulos</a></h2>
            </section>

            <section class="caja">
                <h2><a href="../php/contacto.html">Soporte/Contacto</a></h2>
            </section>

            <section class="caja">
                <h2><a href="../html/info_extra.html">Info Extra</a></h2>
            </section>

            <section class="caja">
                <h2><a href="../php/cuenta.php">Cuenta</a></h2>
            </section>

        </div>

    </div>

    <!-- Codigo de la pagina -->

    <div class="cuenta">

        <div class="fotoperfil">
            <span style="font-size: 55px;">
                <?php echo $emoji; ?>
            </span>
        </div>

        <h2>Mi cuenta</h2>

        <div class="GridCuenta">

            <div class="datoscuenta">
                <label>Nombre de usuario</label>
                <p><?php echo htmlspecialchars($nombre); ?></p>
            </div>

            <div class="datoscuenta">
                <label>Estado de la cuenta</label>
                <p>Cuenta activa</p>
            </div>

            <div class="datoscuenta">
                <label>Tipo de usuario</label>
                <p>Usuario del sistema</p>
            </div>

            <div class="datoscuenta">
                <label>Ocupacion</label>
                <p><?php echo htmlspecialchars($ocupacion); ?></p>
            </div>

        </div>
<button class="boton cerrarsesion" onclick="location.href='../php/index.php'">
    Cerrar sesión
</button>

    </div>

</body>
</html>