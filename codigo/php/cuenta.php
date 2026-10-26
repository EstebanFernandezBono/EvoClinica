
<?php
session_start();

if (!isset($_SESSION['nombre_usuario'])) {
    header("Location: index.php");
    exit;
}

$nombre = $_SESSION['nombre_usuario'];
$ocupacion = $_SESSION['ocupacion'];

//foto de perfil

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

    <div class="flex">

        <div class="logo">
            <img src="../imagenes/logo.png">
        </div>

        <div class="contenedor">

            <section class="caja">
                <h2><a href="../html/modulos.html" traduccion="modulos">Modulos</a></h2>
            </section>

            <section class="caja">
                <h2><a href="../php/contacto.html" traduccion="soporte_contacto">Soporte/Contacto</a></h2>
            </section>

            <section class="caja">
                <h2><a href="../html/info_extra.html" traduccion="info_extra">Info Extra</a></h2>
            </section>

            <section class="caja">
                <h2><a href="../php/cuenta.php" traduccion="cuenta">Cuenta</a></h2>
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

        <h2 traduccion="mi_cuenta">Mi cuenta</h2>

        <div class="GridCuenta">

            <div class="datoscuenta">
                <label traduccion="nombre_usuario">Nombre de usuario</label>
                <p><?php echo htmlspecialchars($nombre); ?></p>
            </div>

            <div class="datoscuenta">
                <label traduccion="estado_cuenta">Estado de la cuenta</label>
                <p traduccion="cuenta_activa">Cuenta activa</p>
            </div>

            <div class="datoscuenta">
                <label traduccion="tipo_usuario">Tipo de usuario</label>
                <p traduccion="usuario_sistema">Usuario del sistema</p>
            </div>

            <div class="datoscuenta">
                <label traduccion="ocupacion">Ocupacion</label>
                <p traduccion="<?php echo $ocupacion == 'Modulo de Ambulancias' ? 'modulo_ambulancias' : 'modulo_documentacion'; ?>"><?php echo htmlspecialchars($ocupacion); ?></p>
            </div>
        </div>

        <button class="boton cerrarsesion" onclick="location.href='../php/index.php'" traduccion="cerrar_sesion">
            Cerrar sesión
        </button>

        <form action="eliminar_cuenta.php" method="POST" onsubmit="return confirm(traduccionesConfirmacion());">
            <button type="submit" class="eliminarcuenta" traduccion="eliminar_cuenta">
                Eliminar cuenta
            </button>
        </form>

        <script>
        function confirmarEliminacion() {
            return confirm("¿Seguro que quieres eliminar tu cuenta?");
        }
        </script>

    </div>
<script src="../javascript/idioma.js"></script>
</body>
</html>
