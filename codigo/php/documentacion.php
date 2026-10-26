
<?php

$conexion = new PDO(
    "mysql:host=localhost;dbname=evoclinica;charset=utf8mb4",
    "root",
    ""
);

// Descargar documento
if (isset($_GET["descargar"])) {

    $consulta = $conexion->prepare(
        "SELECT nombre_archivo, archivo FROM documentos WHERE id = ?"
    );

    $consulta->execute([$_GET["descargar"]]);
    $documento = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($documento) {
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" .
            basename($documento["nombre_archivo"]) . "\"");

        echo $documento["archivo"];
        exit;
    }
}

// Subir documento
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["subir"])) {

    $archivo = $_FILES["archivo"];

    if ($archivo["name"] && !$archivo["error"]) {

        $contenido = file_get_contents($archivo["tmp_name"]);

        $consulta = $conexion->prepare(
            "INSERT INTO documentos (paciente, nombre_archivo, archivo)
            VALUES (?, ?, ?)"
        );

        $consulta->execute([
            $_POST["paciente"],
            $archivo["name"],
            $contenido
        ]);
    }

    header("Location: documentacion.php");
    exit;
}

// Borrar documento
if (isset($_POST["borrar"])) {

    $consulta = $conexion->prepare(
        "DELETE FROM documentos WHERE id = ?"
    );

    $consulta->execute([$_POST["id"]]);

    header("Location: documentacion.php");
    exit;
}

// Modificar documento
if (isset($_POST["guardar"])) {

    if ($_FILES["archivo"]["name"] && !$_FILES["archivo"]["error"]) {

        $contenido = file_get_contents($_FILES["archivo"]["tmp_name"]);

        $consulta = $conexion->prepare(
            "UPDATE documentos
            SET paciente = ?, nombre_archivo = ?, archivo = ?
            WHERE id = ?"
        );

        $consulta->execute([
            $_POST["paciente"],
            $_FILES["archivo"]["name"],
            $contenido,
            $_POST["id"]
        ]);

    } else {

        $consulta = $conexion->prepare(
            "UPDATE documentos SET paciente = ? WHERE id = ?"
        );

        $consulta->execute([
            $_POST["paciente"],
            $_POST["id"]
        ]);
    }

    header("Location: documentacion.php");
    exit;
}

// Buscar documento para modificar
$editar = null;

if (isset($_GET["modificar"])) {

    $consulta = $conexion->prepare(
        "SELECT * FROM documentos WHERE id = ?"
    );

    $consulta->execute([$_GET["modificar"]]);
    $editar = $consulta->fetch(PDO::FETCH_ASSOC);
}

// Mostrar documentos
$consulta = $conexion->query(
    "SELECT * FROM documentos ORDER BY fecha_subida DESC"
);

$documentos = $consulta->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>MóduloDocumentacion</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/documentacion.css">
</head>

<body>

<br>

<div class="titulopagina">
    <h1 traduccion="titulo">EvoClinica</h1>
</div>

<div class="flexdocumentacion">

    <aside class="menudocumentacion">

        <details open>

            <summary><p traduccion="gestion_documentos">Gestión de Documentos</p></summary>

            <?php if ($editar) { ?>

                <h3 traduccion="modificar_documento">Modificar documento</h3>

                <form action="documentacion.php" method="POST"
                    enctype="multipart/form-data">

                    <input type="hidden" name="id"
                        value="<?php echo $editar["id"]; ?>">

                    <label traduccion="nombre_paciente">Nombre del paciente:</label>

                    <input type="text" name="paciente"
                        value="<?php echo htmlspecialchars($editar["paciente"]); ?>"
                        required>

                    <label traduccion="reemplazar_archivo">Reemplazar archivo (opcional):</label>

                    <input type="file" name="archivo"
                        accept=".doc,.docx,.pdf">

                    <button type="submit" name="guardar" traduccion="guardar_cambios">
                        Guardar cambios
                    </button>

                    <a href="documentacion.php" traduccion="cancelar">Cancelar</a>

                </form>

            <?php } else { ?>

                <form action="documentacion.php" method="POST"
                    enctype="multipart/form-data">

                    <label traduccion="nombre_paciente">Nombre del paciente:</label>

                    <input type="text" name="paciente"
                        traduccion-placeholder="placeholder_paciente"
                        placeholder="Nombre del paciente" required>

                    <label traduccion="seleccionar_documento">Seleccionar documento:</label>

                    <input type="file" name="archivo"
                        accept=".doc,.docx,.pdf" required>

                    <button type="submit" name="subir" traduccion="subir_documento">
                        Subir documento
                    </button>

                </form>

            <?php } ?>

        </details>

    </aside>

    <main class="contenidodocumentacion">

        <h2 traduccion="modulo_documentacion">Módulo de Documentación</h2>

        <br>

        <div class="paneldocumentacion">

            <h3 traduccion="documentos">Documentos</h3>

            <table>

                <tr>
                    <th traduccion="paciente">Paciente</th>
                    <th traduccion="documento">Documento</th>
                    <th traduccion="fecha">Fecha</th>
                    <th traduccion="acciones">Acciones</th>
                </tr>

                <?php foreach ($documentos as $documento) { ?>

                    <tr>

                        <td>
                            <?php echo htmlspecialchars($documento["paciente"]); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($documento["nombre_archivo"]); ?>
                        </td>

                        <td>
                            <?php echo date(
                                "d/m/Y H:i",
                                strtotime($documento["fecha_subida"])
                            ); ?>
                        </td>

                        <td>

                            <div class="acciones">

                                <a href="documentacion.php?descargar=<?php echo $documento["id"]; ?>">
                                    <button type="button" traduccion="descargar">Descargar</button>
                                </a>

                                <a href="documentacion.php?modificar=<?php echo $documento["id"]; ?>">
                                    <button type="button" traduccion="modificar">Modificar</button>
                                </a>

                                <form action="documentacion.php" method="POST"
                                    onsubmit="return confirm(traduccionesConfirmacion());">

                                    <input type="hidden" name="id"
                                        value="<?php echo $documento["id"]; ?>">

                                    <button type="submit" name="borrar"
                                        class="eliminar" traduccion="borrar">
                                        Borrar
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                <?php } ?>

            </table>

        </div>

    </main>

</div>
<script src="../javascript/idioma.js"></script>
</body>
</html>
