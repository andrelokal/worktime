<?php
include_once('util/config.php');

?>


<link href="chat.css" rel="stylesheet" type="text/css" />

<?php

if(@$_SESSION['sala']){
    include_once('view/formChat.php');
    //header('Location: '.PATH.'view/formChat.php');
}else{
    include_once('view/formLogin.php');
    //header('Location: '.PATH.'view/formLogin.php');    
}
    
?>