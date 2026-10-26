
<!DOCTYPE html>
<html lang="en">
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
<h1 traduccion="titulo">Hospital de Clínicas</h1> </div>


    <div class="flex">

    <div class="logo">
        <img src="../imagenes/logo.png">
    </div>


    <div class="contenedor">

        <section class="caja">
            <h2><a href="../html/modulos.html" traduccion="modulos">Modulos</h2></a>
        </section>

        <section class="caja">
            <h2><a href="../php/contacto.html" traduccion="soporte_contacto">Soporte/Contacto</h2></a>
        </section>

        <section class="caja">
            <h2><a href="../html/info_extra.html" traduccion="info_extra">Info Extra</h2></a>
        </section>

        <section class="caja">
            <h2><a href="../php/cuenta.php" traduccion="cuenta">Cuenta</a></h2>
        </section>
    </div>
    </div>

    
    <!--  Codigo de la pagina  -->
<br>
<h1 traduccion="titulo_soporte">Soporte y Contacto</h1>
    <div class="formulario">
    <h2 style="text-align: center;" traduccion="enviar_consulta">Envíanos tu consulta</h2>

        <form class="consultas">
        <div>
            <label traduccion="nombre">Nombre</label>
            <input type="text">
</div>
    <div>
    <label traduccion="apellido">Apellido</label>
        <input type="text">
            </div>

    <div>
    <label traduccion="correo_electronico">Correo electrónico</label>
        <input type="email">
            </div>

            <div>
                <label traduccion="telefono">Teléfono</label>
                <input type="tel">
            </div>

            <div class="ancho">
            <label traduccion="consulta">Consulta</label>
            <input type="text">
            </div>

            <div class="ancho">
            <label traduccion="mensaje">Mensaje</label>
            <textarea rows="5" traduccion-placeholder="placeholder_mensaje" placeholder="Describa aqui su consulta, almenos 20 palabras o mas..."></textarea>
            </div>

            <div class="ancho">
            <button type="submit" traduccion="enviar">Enviar</button>
</div>
</form>
</div>
<script src="../javascript/idioma.js"></script>
</body>
</html>
