<?php


session_start();

if(isset($_SESSION['autenticado']) && $_SESSION['autenticado']=="SI"){
    
    session_unset();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    header("refresh:5 , url=/index.html");
}else{
    header("location: /index.html");
    exit;
}


?>


será redirigido a index en 5 sencs