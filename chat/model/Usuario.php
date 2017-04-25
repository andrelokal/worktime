<?php

class Usuario{
	
	// atributos da classe
	private $nome;
	private $texto;
    private $sala;
    private $arq;
	
	//construtor da classe
 	public function Usuario($sala = '',$path = ''){
        $this->sala = $sala;
	    if($this->sala && $path){
            $this->arq = new ArqLog($this->sala,$path);    
        }
        	
	}
	
	//metodos de acesso
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
	
	//metodo de persistencia
	public function save($path){
		
			if($this->sala != ''){
					$objArq = new ArqLog($this->sala, $path);
					$data = array('nome'=> $this->nome, 'texto'=> $this->texto,'hora'=>date('H:i'));
					$objArq->setData($data);
					return true;
			}else{
				return false;
			}
	
	}
    
    public function striptags($text, $tags = '', $invert = FALSE) {
		$text = preg_replace('|https?://www\.[a-z\.0-9]+|i', '<strong>Proibido URLs!</strong>', $text);
		$text = preg_replace('|www\.[a-z\.0-9]+|i', '<strong>Proibido URLs!</strong>', $text);		
		//$text = str_replace(range(0, 9), null, $text);
		//$text = preg_replace('/\d+$/', null, $text);
		
		preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
		$tags = array_unique($tags[1]);
	
		if(is_array($tags) AND count($tags) > 0) {
			if($invert == FALSE) {
				return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
			}
			else {
				return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text);
			}
		}
		elseif($invert == FALSE) {
			return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
		}
		
		return $text;
	}
	
	
} 
?>
