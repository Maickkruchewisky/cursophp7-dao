<?php

require_once("config.php");

//Carrega um usuário
//$maic = new Usuario();
//$maic->loadById(21);
//echo $maic;

// Carrega uma lista de usuários 
//$lista = Usuario::getList();
//echo json_encode($lista);	

// Carrega uma lista de usuários buscando pelo login
//$search = Usuario::search("a");
//echo json_encode($search);

//Carrega um usuário usando o login e a senha
$usuario = new Usuario();
$usuario->loguin("ana", "miguel");

echo $usuario;
?>