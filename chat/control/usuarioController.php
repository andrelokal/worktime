<?php

include_once('../util/config.php');

$action = '';
@$action = $_POST['action'];

//caminho do diretorio que quero salvar
$diretorio = '../arquivos';

if($action == ''){
   $action = $_POST['form'][0]['value'];  
}

switch ($action) {
    
    case 1: // Logar no chat
    
        $_SESSION['nome'] = $_POST['nome'];
        $_SESSION['sala'] = $_POST['sala'];
        $_SESSION['senha'] = $_POST['senha'];
        header('Location: ../index.php');
          
    break;
    
    case 2: //Enviar mensagens
        
        $usuario = new Usuario();

        $usuario->setNome($usuario->striptags($_SESSION['nome']));
        $usuario->setTexto($usuario->striptags($_POST['form'][1]['value']));
        $usuario->setSala($usuario->striptags($_SESSION['sala'].$_SESSION['senha']));
        
        $response = $usuario->save($diretorio);
        
        echo json_encode(array('success'=>$response)); 
        
        /*
        $usuario = new Usuario($_SESSION['sala'].$_SESSION['senha'],$diretorio);

        foreach($usuario->getData() as $value){
             
            if(json_decode($value,true) != null){
                $data[] = json_decode($value,true);    
            }           
        }
        echo json_encode($data); 
        */
    break;
    
    case 3: //Carregar mensagens
        
        $usuario = new Usuario($_SESSION['sala'].$_SESSION['senha'],$diretorio);

        foreach($usuario->getData() as $value){
             
            if(json_decode($value,true) != null){
                $data[] = json_decode($value,true);    
            }           
        }
        echo json_encode($data);
        
    break;
    
    case 4: // Sair do chat

        session_destroy();
        echo json_encode(array('success'=>true)); 
        
    break;

    default:
       header('Location: '.PATH.'index.php');
}

?>
