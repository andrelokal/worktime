<?php
if(!isset($_SESSION)){
    @session_start();    
}


//Configuração de Ambiente
ini_set('short_open_tag','1');
date_default_timezone_set('America/Sao_Paulo');
// --- //

//definicao dos caminhos e rotas do projeto
define("PATH_ROOT", @($_SERVER['DOCUMENT_ROOT']."/worktime/chat/"));
define("PATH", @($_SERVER['HTTP_REFERER']."/worktime/chat/"));
define("HOST", @($_SERVER['SERVER_ADDR']));
// ----- //


//autoload das classes
function __autoload($classe){
	if(!@include_once "../model/".$classe.".php");
		if(!@include_once "../util/".$classe.".php");
			if(!@include_once "../control/".$classe.".php");
				if(!@include_once "../view/".$classe.".php");
}

?>