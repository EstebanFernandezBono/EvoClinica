<?php

include "conexion.php";

$traslado_modificar = null;

if (isset($_GET["id"])) {

    $id = filter_var($_GET["id"], FILTER_VALIDATE_INT);

    if (!$id) {
        exit("ID inválido");
    }

    $sql = "SELECT * FROM traslados WHERE id = ?";
    $consulta = $conexion->prepare($sql);
    $consulta->execute([$id]);

    $traslado_modificar = $consulta->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["registrar"])) {

        $destino = $_POST["destino"];
        $fecha = $_POST["fecha"];
        $hora_salida = $_POST["hora_salida"];
        $hora_llegada = $_POST["hora_llegada"];
        $conductor = $_POST["conductor"];

        $sql = "INSERT INTO traslados (destino, fecha, hora_salida, hora_llegada, conductor)
                VALUES (?, ?, ?, ?, ?)";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            $destino,
            $fecha,
            $hora_salida,
            $hora_llegada,
            $conductor
        ]);

        header("Location: ambulancias.php");
        exit;
    }

    if (isset($_POST["eliminartraslado"])) {

        $id = $_POST["id"];

        $sql = "DELETE FROM traslados WHERE id = ?";

        $consulta = $conexion->prepare($sql);
        $consulta->execute([$id]);

        header("Location: ambulancias.php");
        exit;
    }

    if (isset($_POST["modificartraslado"])) {

        $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);

        if (!$id) {
            exit("ID inválido");
        }

        $destino = $_POST["destino"];
        $fecha = $_POST["fecha"];
        $hora_salida = $_POST["hora_salida"];
        $hora_llegada = $_POST["hora_llegada"];
        $conductor = $_POST["conductor"];

        $sql = "UPDATE traslados
                SET destino = ?, fecha = ?, hora_salida = ?,
                    hora_llegada = ?, conductor = ?
                WHERE id = ?";

        $consulta = $conexion->prepare($sql);

        $consulta->execute([
            $destino,
            $fecha,
            $hora_salida,
            $hora_llegada,
            $conductor,
            $id
        ]);

        header("Location: ambulancias.php");
        exit;
    }
}

$consulta = $conexion->query("SELECT * FROM traslados ORDER BY id DESC");

$traslados = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>EvoClinica</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/ambulancias.css">

</head>
<body>
<br>
<h1 class="titulopagina" traduccion="titulo">Hospital de Clínicas</h1>
<div class="contenidoambulancias">

<div class="ambulanciasregistradas">
<h2 traduccion="registrar_traslado">Registrar traslado</h2>

<form class="formambulancias" method="POST">

<?php if ($traslado_modificar) { ?>
    <input type="hidden" name="id" value="<?php echo $traslado_modificar["id"]; ?>">
    <?php } ?>

<div>
    <label traduccion="direccion_destino">Dirección de destino</label>
    <input type="text" id="direccion" required>
</div>

<div>
    <label traduccion="departamento">Departamento</label>
    <select id="departamento" required>
        <option value="" traduccion="seleccionar_departamento">Seleccionar departamento</option>
        <option value="Artigas">Artigas</option>
        <option value="Canelones">Canelones</option>
        <option value="Cerro Largo">Cerro Largo</option>
        <option value="Colonia">Colonia</option>
        <option value="Durazno">Durazno</option>
        <option value="Flores">Flores</option>
        <option value="Florida">Florida</option>
        <option value="Lavalleja">Lavalleja</option>
        <option value="Maldonado">Maldonado</option>
        <option value="Montevideo">Montevideo</option>
        <option value="Paysandú">Paysandú</option>
        <option value="Río Negro">Río Negro</option>
        <option value="Rivera">Rivera</option>
        <option value="Rocha">Rocha</option>
        <option value="Salto">Salto</option>
        <option value="San José">San José</option>
        <option value="Soriano">Soriano</option>
        <option value="Tacuarembó">Tacuarembó</option>
        <option value="Treinta y Tres">Treinta y Tres</option>
    </select>
</div>

<input type="hidden" name="destino" id="destinoCompleto">

<div class="ambulanciagrid">
<button type="button" class="boton" onclick="calcularRuta()" traduccion="trazar_ruta">
    Trazar ruta
</button>
</div>

            <div>
                <label traduccion="fecha">Fecha</label>
                <input type="date" name="fecha"
                value="<?php echo $traslado_modificar["fecha"] ?? ""; ?>" required>
            </div>

            <div>
                <label traduccion="hora_salida">Hora de salida</label>
                <input type="time" name="hora_salida"
                value="<?php echo $traslado_modificar["hora_salida"] ?? ""; ?>" required>
            </div>

            <div>
                <label traduccion="hora_llegada">Hora de llegada</label>
                <input type="time" name="hora_llegada"
                value="<?php echo $traslado_modificar["hora_llegada"] ?? ""; ?>" required>
            </div>

            <div class="ambulanciagrid">
                <label traduccion="nombre_conductor">Nombre del conductor</label>
                <input type="text" name="conductor"
                value="<?php echo $traslado_modificar["conductor"] ?? ""; ?>" required>
            </div>

            <div class="ambulanciagrid">

                <?php if ($traslado_modificar) { ?>

                    <button class="boton" type="submit" name="modificartraslado" traduccion="guardar_cambios">
                        Guardar cambios
                    </button>

    <?php } else { ?>
            <button class="boton" type="submit" name="registrar" traduccion="enviar">
                Enviar
            </button>

    <?php } ?>
</div>
</form>
</div>

    <div class="ambulanciasregistradas">

        <h2 traduccion="traslados_registrados">Traslados registrados</h2>

        <table>

            <tr>
                <th traduccion="id">ID</th>
                <th traduccion="destino">Destino</th>
                <th traduccion="fecha">Fecha</th>
                <th traduccion="salida">Salida</th>
                <th traduccion="llegada">Llegada</th>
                <th traduccion="conductor">Conductor</th>
                <th traduccion="modificar">Modificar</th>
                <th traduccion="eliminar">Eliminar</th>
            </tr>

            <?php foreach ($traslados as $traslado) { ?>

            <tr>

                <td><?php echo $traslado["id"]; ?></td>
                <td><?php echo $traslado["destino"]; ?></td>
                <td><?php echo $traslado["fecha"]; ?></td>
                <td><?php echo $traslado["hora_salida"]; ?></td>
                <td><?php echo $traslado["hora_llegada"]; ?></td>
                <td><?php echo $traslado["conductor"]; ?></td>

                <td>
                    <form method="GET">
                        <input type="hidden" name="id" value="<?php echo $traslado["id"]; ?>">

            <button type="submit" name="modificartraslado"  class="eliminartraslado" traduccion="modificar">
            Modificar
            </button>
                    </form>
                </td>

                <td>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $traslado["id"]; ?>">

                <button type="submit" name="eliminartraslado" class="eliminartraslado" traduccion="eliminar">
            Eliminar
            </button>
                    </form>
                </td>

            </tr>

            <?php } ?>
</table>
</div>
</div>

<!-- codigo del mapa !-->
<div id="mapa">

</div>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="../javascript/mapa.js"></script>
<script src="../javascript/idioma.js"></script>
</body>
</html>