<h1 class="nombre-pagina">Olvidé Password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu e-mail a continuación</p>

<?php include_once __DIR__.'/../templates/alertas.php';?>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu e-mail" name="email" id="email">
    </div>

    <input type="submit" class="boton" value="Enviar instrucciones">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Iniciar Sesión</a>
    <a href="/crear">¿Aún no tienes una cuenta? Crear Una</a>
</div>