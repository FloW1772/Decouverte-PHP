<?php

    setcookie('salut', 'salut a tous');
    var_dump($_COOKIE);
    session_start();

    if('je retrouve un utilisateur dans ma bd'){
        $_SESSION['login'] = 'login';

    }

    //tant que $_SESSION['login'] n'est pas vide -- vous etes connectés


    if('je clique sur déconnexion') {
        unset($_SESSION['login']);

        session_destroy();
    }



?>


<h1>Salut !</h1>
