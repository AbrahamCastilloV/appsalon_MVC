<?php 
namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;

class LoginController{
    public static function login(Router $router){
        $alertas = [];
        $auth = new Usuario($_POST);

        if($_SERVER['REQUEST_METHOD']==='POST'){
            //Verificar espacios vacíos
            $auth = new Usuario($_POST);
            $alertas = $auth ->validarLogin();
            if(empty($alertas)){
                //Verificar que el usuario exista
                $usuario = Usuario::where('email', $auth ->email);
                if($usuario){
                    //verificar si la contraseña coincida
                    if($usuario ->comprobarPasswordAndVerificado($auth->password)){
                        //Autenticar al usuario
                        session_start();
                        $_SESSION['login']=true;
                        $_SESSION['id']=$usuario ->id;
                        $_SESSION['email']=$usuario ->email;
                        $_SESSION['nombre']=$usuario ->nombre." ".$usuario ->apellido;
                        //Redireccionamiento
                        if($usuario->admin ==='1'){
                            $_SESSION['admin']=$usuario ->admin??null;
                            header('Location: /admin');
                        }else{
                            header('Location: /cita');
                        }
                    }
                }else{
                    Usuario::setAlerta('error','Usuario No Encontrado');
                }
            } 
        }
        $alertas=Usuario::getAlertas();
        $router ->render('auth/login', [
            'alertas' =>$alertas,
            'auth' =>$auth    
        ]);
    }
    public static function logout(){
        session_start();

        $_SESSION = [];
        
        header('Location: /');
    }
    public static function olvide(Router $router){
        $alertas=[];

        if($_SERVER['REQUEST_METHOD']==='POST'){
        $auth = new Usuario($_POST);
        $alertas = $resultado = $auth->validarEmail();
        if(empty($alertas)){
            $usuario = Usuario::where('email', $auth->email);
            if($usuario && $usuario->confirmado==='1'){
            echo "el usuario existe y está confirmado";
            $usuario ->crearToken();
            $usuario ->guardar();
            //Crear un email con los datos del usuario
            $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
            $email ->enviarInstrucciones();
            Usuario::setAlerta('exito','Se enviaron las instrucciones para recuperar contraseña al correo');
            }else{
            Usuario::setAlerta('error','El usuario no existe o no está confirmado');
            }  
        }   

        };
        $alertas = Usuario::getAlertas();
        $router ->render('auth/olvide', [
            'alertas'=>$alertas
            
        ]);
    }
    public static function recuperar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        $error=false;
        
        $usuario = Usuario::where('token', $token);
    
        if(empty($usuario)){
            Usuario::setAlerta('error','Token No Válido!');
            $error=true;
        }

        
        if($_SERVER['REQUEST_METHOD']==='POST'){
        $usuario->sincronizar($_POST);
        
        $alertas = $usuario ->validarNuevaCuenta();
        if(empty($alertas)){
            $usuario ->hashPassword();
            $usuario->token = null;
            $resultad = $usuario ->guardar();
            
            if($resultado){
                header('Location: /');

            }
        }
        };

        $alertas = Usuario::getAlertas();
        $router ->render('auth/recuperar',[
            'alertas'=>$alertas,
            'error'=>$error
        ]);
    }
    public static function crear(Router $router){
        $usuario = new Usuario;
        //Alertas vacías
        $alertas=[];

        if($_SERVER['REQUEST_METHOD']==='POST'){
            $usuario ->sincronizar($_POST);
            $alertas = $usuario ->validarNuevaCuenta();
            //Revisar que el arreglo de errores esté vacío
            if(empty($alertas)){
                //Verificar que el usuario no esté registrado
               $resultado = $usuario ->existeUsuario();
               if($resultado->num_rows){
                $alertas = Usuario::getAlertas();
            }else{
                //REGISTRANDO AL USUARIO
                //Hashear el password
                $usuario ->hashPassword();
                //Generar un token único(anti robots)
                $usuario ->crearToken();
                //Enviar un email para confirmación de token
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                $email ->enviarConfirmacion();
                //Crear el usuario
                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /mensaje');
                }
            }
            }
        }
        $router ->render('auth/crear', [
            'usuario' =>$usuario,
            'alertas' =>$alertas

        ]);
    }
    public static function mensaje(Router $router){
        $router ->render('auth/mensaje');
    }
    public static function confirmar(Router $router){
        $alertas = [];
        $token = s($_GET['token']);
        
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
        //mostrar mensaje de error
            Usuario::setAlerta('error','Token No Válido!');

        }else{
            //Mostrar mensaje de éxito y modificar a usuario confirmado
            Usuario::setAlerta('exito','Cuenta Comprobada Correctamente. Usuario validado!');
            $usuario ->confirmado = '1';
            $usuario ->token = null;
            $usuario ->guardar();
        }
       $alertas = Usuario::getAlertas();

        $router ->render('auth/confirmar',[
            'alertas'=>$alertas
        ]);
    }
}