<h1 class="nombre-pagina">Restablecer contraseña</h1>
<p  class="descripcion-pagina">Coloca tu nuevo password a continuación</p>

<?php include_once __DIR__.'/../templates/alertas.php';?>
<?php if($error === true){
    return null;
};?>


<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Tu Nuevo Password" name="password" >
    </div>
    <input type="submit" class="boton" value="Guardar Nuevo Password">
</form>

<div class="acciones">
    <a href="/crear">¿Aún no tienes una cuenta? Crear Una</a>
    <a href="/">Iniciar Sesión</a>
</div>