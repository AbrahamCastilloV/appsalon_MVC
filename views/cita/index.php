<h1 class="nombre-pagina">Crear una nueva cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

<?php include_once __DIR__.'/../templates/barra.php';?>

<div id="app">
    <nav class="tabs">
        <button class="actual"type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    <div class="seccion" id="paso-1">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>

    <div class="seccion" id="paso-2">
        <h2>Tus datos y Cita</h2>
        <p class="text-center">Coloca tus datos y hora de tu cita</p>
        <form class="formulario"action="">
            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input id="nombre" type="text" placeholder="Tu nombre" value="<?php echo $nombre ;?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha:</label>
                <input id="fecha" type="date" min="<?php echo date('Y-m-d');?>">
            </div>
            <div class="campo">
                <label for="hora">Hora:</label>
                <input id="hora" type="time">
            </div>
            <input type="hidden" id="id" value="<?php echo $id;?>">
        </form>
    </div>

    <div class="seccion contenido-resumen" id="paso-3">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>

    <div class="paginacion">
        <button class="boton" id="anterior" type="">&laquo; Anterior</button>
        <button class="boton" id="siguiente" type="">Siguiente &raquo;</button>
    </div>
</div>

<?php $script="
<script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/app.js'></script>
" ;?>
