<?php
class ArqLog{
    
    public $content = "";
    public $fileName = "";
    
    public function ArqLog($nomArq, $path){
        
        $this->fileName = $path.'/'.$nomArq.".txt";
        
        if(file_exists($this->fileName)){            
            $this->content = file_get_contents($this->fileName);    
        }else{            
            file_put_contents($this->fileName,"\n");
            chmod($this->fileName, 0777);            
        }        
    }
    
    public function setData($data = array()){
        $data = json_encode($data);
        file_put_contents($this->fileName,$data."\n", FILE_APPEND);
        $this->content = file_get_contents($this->fileName);    
    }
    
    public function getData(){     
        return explode("\n",$this->content);   
    }
}
?>