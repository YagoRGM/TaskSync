<?php
    $dbhost="localhost";
    $dbusuario="root";
    $dbpassword="";
    $dbname="taskasync";

    $conexao = mysqli_connect($dbhost,$dbusuario,$dbpassword,$dbname);
    
    if(!$conexao){
        die("Falhou a conexão". mysqli_connect_error());
    }
?>