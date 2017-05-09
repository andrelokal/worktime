<?php

class Usuario{
	
	// atributos da classe
	private $nome;
	private $texto;
    private $sala;
    private $arq;
    private $cor;
	
	//construtor da classe
 	public function Usuario($sala = '',$path = ''){
        $this->sala = $sala;
	    if($this->sala && $path){
            $this->arq = new ArqLog($this->sala,$path);    
        }
        	
	}
	
    //metodos de acesso
	
    public function setCor($x){
        $this->cor = $x;
    }
    
    public function setNome($x){
		$this->nome = $x;
	}
	
	public function setTexto($x){
		$this->texto = $x;
	}
    
    public function setSala($x){
        $this->sala = $x;
    }
	
	public function getNome(){
			return $this->nome;
	}
	
	public function getTexto(){
			return $this->texto;
	}
    
    public function getData(){
        return $this->arq->getData();
    }
    
    public function getSala(){
        return $this->sala;
    }
    
    public function getCor($x){
        return $this->cor;
    }
	
	//metodo de persistencia
	public function save($path){
		
			if($this->sala != ''){
					$objArq = new ArqLog($this->sala, $path);
					$data = array('nome'=> $this->nome, 'texto'=> $this->texto,'hora'=>date('H:i:s'),'cor'=>$this->cor);
					$objArq->setData($data);
					return true;
			}else{
				return false;
			}
	
	}
    
    public function striptags($text, $tags = '', $invert = FALSE) {				
		return strip_tags($text);
	}
	
	
} 
?>
