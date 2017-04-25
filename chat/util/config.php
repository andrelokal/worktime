<?php
session_start();

//Configuração de Ambiente
ini_set('short_open_tag','1');
date_default_timezone_set('America/Sao_Paulo');
// --- //

//definicao dos caminhos e rotas do projeto
define("PATH_ROOT", @($_SERVER['DOCUMENT_ROOT']."/POO/"));
define("PATH", @($_SERVER['HTTP_REFERER']."/POO/"));
define("HOST", @($_SERVER['SERVER_ADDR']));
// ----- //


//autoload das classes
function __autoload($classe){
	if(!@include_once PATH_ROOT."model/".$classe.".php");
		if(!@include_once PATH_ROOT."util/".$classe.".php");
			if(!@include_once PATH_ROOT."control/".$classe.".php");
				if(!@include_once PATH_ROOT."view/".$classe.".php");
}

?>