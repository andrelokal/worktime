<?php
ini_set('short_open_tag','1');
date_default_timezone_set('America/Sao_Paulo');
error_reporting(E_ALL);

$feriados_label = array();

function geraTimestamp($data) 
{
  $partes = explode('/', $data);
  return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}

function orthodox_eastern($year) { 
    $a = $year % 4; 
    $b = $year % 7; 
    $c = $year % 19; 
    $d = (19 * $c + 15) % 30; 
    $e = (2 * $a + 4 * $b - $d + 34) % 7; 
    $month = floor(($d + $e + 114) / 31); 
    $day = (($d + $e + 114) % 31) + 1; 
    
    $de = mktime(0, 0, 0, $month, $day + 13, $year); 
    
    return $de; 
} 

function dias_feriados($ano = null)
{ 
  global $feriados_label;
  
  if ($ano === null)
  {
    $ano = intval(date('Y'));
  }
 
  $pascoa     = orthodox_eastern($ano); // Limite de 1970 ou após 2037 da easter_date PHP consulta http://www.php.net/manual/pt_BR/function.easter-date.php
  $dia_pascoa = date('j', $pascoa);
  $mes_pascoa = date('n', $pascoa);
  $ano_pascoa = date('Y', $pascoa);
 
  $feriados = array(
    // Datas Fixas dos feriados Nacionail Basileiras
    mktime(0, 0, 0, 1,  1,   $ano), // Confraternização Universal - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 4,  21,  $ano), // Tiradentes - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 5,  1,   $ano), // Dia do Trabalhador - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 9,  7,   $ano), // Dia da Independência - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 10,  12, $ano), // N. S. Aparecida - Lei nº 6802, de 30/06/80
    mktime(0, 0, 0, 11,  2,  $ano), // Finados - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 11, 15,  $ano), // Proclamação da republica - Lei nº 662, de 06/04/49
    mktime(0, 0, 0, 12, 25,  $ano), // Natal - Lei nº 662, de 06/04/49
 
    // These days have a date depending on easter
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa),//2ºfeira Carnaval
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa),//3ºfeira Carnaval	
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa),//6ºfeira Santa  
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa),//Pascoa
    mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa),//Corpus Christ
  );
  
  $feriados_label = array(date("Ymd", mktime(0, 0, 0, 1,  1,   $ano)) => 'ANO NOVO',
                          date("Ymd", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa)) => 'CARNAVAL',
                          date("Ymd", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa)) => 'CARNAVAL',
                          date("Ymd", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa)) => 'PAIXAO',
                          date("Ymd", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa)) => 'PASCOA',
                          date("Ymd", mktime(0, 0, 0, 4,  21,  $ano)) => 'TIRADENTES',
                          date("Ymd", mktime(0, 0, 0, 5,  1,   $ano)) => '1o.MAIO',
                          date("Ymd", mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa)) => 'CORPUS CHRISTI',
                          date("Ymd", mktime(0, 0, 0, 9,  7,   $ano)) => 'INDEPENDENCIA',
                          date("Ymd", mktime(0, 0, 0, 10,  12, $ano)) => 'N.S.APARECIDA',
                          date("Ymd", mktime(0, 0, 0, 11, 15,  $ano)) => 'PROCLAMACAO',
                          date("Ymd", mktime(0, 0, 0, 12, 25,  $ano)) => 'NATAL');
  
  
  sort($feriados);   
  return $feriados;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Idleness Center</title>
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css"> -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
  <link href="bootstrap/css/jquery.dynameter.css" rel="stylesheet" type="text/css" />
  <script src="bootstrap/js/bootstrap.js"></script>
  <script src="bootstrap/js/jquery.dynameter.js"></script>
  <script src="jquery.mask.js"></script>


  <script>

  _default =  { 
                entrada:"08:00",
                saida:  "17:48",
                almoco: "11:45"
              }
  
  var config ;
  if( localStorage.getItem('config') ){

    config = JSON.parse( localStorage.getItem('config') );

  } else {

    config =  { 
                entrada:"08:00",
                saida:"17:48",
                almoco: "11:45"
              }
  } 

  var $gaugeCansaco;
  var $gaugeMotivacao;  
  var $gaugeFeriado;
  var $totalDaysOfWeek;
  var HE; //hora entrada
  var ME; // minutos entrada
  var HS; // hora saida
  var MS; // minutos saida
  var MT; // minutos totais de trabalho  
  var HAT; //hora atual
  var HH;
  var MI;
  var SS;
  
  var HA; //Hora almo�o
  var MA; // Minuto almo�o
 
  var AT; // Minutos totais atual
    
  $( function() {
   
   Init()

    $("#progressbar").progressbar({value: 0});
    
    $('#saida,#entrada,#almoco').mask( '99:99' );
    $('#saida,#entrada,#almoco').blur(function(){
        if( !ValidaHora( $(this).val() ) ){
            $(this).val( _default[ $(this).attr('id') ] )
        }   
    })

    $('#config').click(function(){
      $('#myModal').modal()
    });
    $('#btn-pacman').click(function(){
      setFocusIframe('frmPacman');      
      $('#pacman').modal();      
    });
    $('#btn-tetris').click(function(){
        setFocusIframe('frmTetris');      
        $('#tetris').modal();      
    });
    $('#btn-bombergirl').click(function(){
        setFocusIframe('frmBomberGirl');      
        $('#bombergirl').modal();
    });      
    $('#btn-racer').click(function(){
        setFocusIframe('frmRacer');      
        $('#racer').modal();      
    });

    $('#save').click(function(){
      config.entrada = $('#entrada').val();
      config.saida = $('#saida').val();
      config.almoco = $('#almoco').val();
      localStorage.setItem('config', JSON.stringify(config) )
      //alert( JSON.stringify(config) )
      $('#myModal').modal('hide')
      Init()
    })
    
  });

  function ValidaHora( valor ){
      
    if( valor.length != 5 )  return false;
      
    var regex = /([0-9]{2})\:([0-9]{2})/;
    var m = regex.exec(valor);
    
    if( !m[1] ){
        return false;
    }
    
    if( !m[2] ){
        return false;
    }
    
    H = Number(m[1]);
    M = Number(m[2]);
    
    if( Number(H) > 23  ){
       return false; 
    }
    
    if( Number(M) > 59  ){
       return false; 
    }
    
    return true;
            
  }
  
  function Init(){
     if( config.entrada ){
        $('#entrada').val(config.entrada)
        var regex = /([0-9]{2})\:([0-9]{2})/;
        var m = regex.exec(config.entrada);
        HE = Number(m[1]);
        ME = Number(m[2]);
      }

      if( config.saida ){
        $('#saida').val(config.saida)
        var regex = /([0-9]{2})\:([0-9]{2})/;
        var m = regex.exec(config.saida);
        HS = Number(m[1]);
        MS = Number(m[2]);
        $('.end').html(HS + ":" + MS);
      }
      
      if( config.almoco ){
        $('#almoco').val(config.almoco)
        var regex = /([0-9]{2})\:([0-9]{2})/;
        var m = regex.exec(config.almoco);
        HA = Number(m[1]);
        MA = Number(m[2]);
      }
      
      
      
      MT = (HS-HE)*60+(MS-ME);
      AT = (HA-HE)*60+(MA-ME);       

      HH = HS;
      MI = MS;
      SS = 00; 

      atualizaContador();
      Horario()
  }

  </script>


        <title>Contagem regressiva</title>

        <script type="text/javascript">

            function atualizaContador() {

                var hoje = new Date();

                var todayd= hoje.getDate();

                var todaym= hoje.getMonth();

                var todayy= hoje.getFullYear();

                var futuro = new Date(todayy,todaym+1,todayd,HH,MI,SS);
                
                var $week = new Date(todayy,todaym,todayd,HH,MI,SS);                
                
                var $day = $week.getDay();
                
                var $weekday = new Array(6);
                
                $weekday[0]=0;
                $weekday[1]=5;
                $weekday[2]=4;
                $weekday[3]=3;
                $weekday[4]=2;
                $weekday[5]=1;
                $weekday[6]=0;
                                
                $totalDaysOfWeek = $weekday[$day];                
                
                var ss = parseInt((futuro - hoje) / 1000);

                var mm = parseInt(ss / 60);

                var hh = parseInt(mm / 60);

                var dd = parseInt(hh / 24);

                ss = ss - (mm * 60);

                mm = mm - (hh * 60);

                hh = hh - (dd * 24);

                var pad = "0000"
                
                var hours = pad.substring(0, pad.length - hh.length) + hh;
                var minutes = pad.substring(0, pad.length - mm.length) + mm;
                var seconds = pad.substring(0, pad.length - ss.length) + ss;
                
                var faltam = '';

                faltam += hours > 0 ? hours.padStart(2, '0') + ':' : '';

                faltam += minutes.padStart(2, '0') + ':';

                faltam += seconds.padStart(2, '0');

                HAT = hoje.getHours();
                
                
                
                if (dd+hh+mm+ss > 0) {
                    
                    if ($totalDaysOfWeek == 0) {
                        faltam = 'Falta nada!!! Fim de semana caralho!!!';
                    }else if(HAT < HE || HAT > HS){
                        faltam = 'Falta nada!!! Nos vemos em breve ;)';   
                    }
                    
                    $('#contador').html(faltam);
                    setTimeout(atualizaContador,1000);
                    setTimeout(Horario,1000);

                } else {

                    $('#contador').html('CHEGOU!!!!');
                    setTimeout(atualizaContador,1000);
                    setTimeout(Horario,1000);

                }

            }

        function setFocusIframe(frameID) {            
            $("#" + frameID).trigger("click");            
        }
            
        function Horario(){  
            Elem = $("#Clock");
                    var Hoje = new Date(); 
                    var Horas = Hoje.getHours(); 
                    if(Horas < 10){ 
                        Horas = "0"+Horas; 
                    } 
                    var Minutos = Hoje.getMinutes(); 
                    if(Minutos < 10){ 
                        Minutos = "0"+Minutos; 
                    } 
                    var Segundos = Hoje.getSeconds(); 
                    if(Segundos < 10){ 
                        Segundos = "0"+Segundos; 
                    } 
                    Elem.html( Horas+":"+Minutos+":"+Segundos );
                    
                    pbar(Number(Horas),Number(Minutos));
                    //window.setInterval("Horario()",1000); 
                    
           }
           
           function pbar(h,m){
               
               var a2 = (h*60+m)-(HE*60+ME);
               var b1 = 100;
               var a1 = MT;
               var a3 = AT;               
               var p = (b1*a2)/a1;
               var pa = (b1*a2)/a3;
               
               if(p > 100){
                   p = 100;
               }
               
               if(p < 0){
                   p = 0;
               }
               
               if(pa > 100){
                   pa = p-15;   
               }
               
               if(pa < 0){
                    pa = 0; 
               } 
               
               if ($totalDaysOfWeek == 0) {
                   p = 100;
                   pa = 0;
                   $totalDaysOfWeek = 1;
                   var $multiply = 0;
               }else{
                   var $multiply = 1;
               }
                             
               var percentEndOfWeek = (100 * (a2 + ((5 - $totalDaysOfWeek) * a1)) / (a1 * 5));
               
               $gaugeCansaco = $('#payloadGaugeCansaco').dynameter({
                    label: 'di&aacute;rio',
                    value: Math.round(p * $multiply),
                    unit: '% cansa&ccedil;o',
                    min: 0,
                    max: 100,
                    regions: {
                        75: 'warn',
                        90: 'error'
                    }
                });
                
                $gaugeMotivacao = $('#payloadGaugeMotivacao').dynameter({
                    label: 'fim de semana',
                    value: Math.round(percentEndOfWeek),
                    unit: '% motiva&ccedil;&atilde;o p/',
                    min: 0,
                    max: 100,
                    regions: {
                        0: 'error',
                        50: 'warn',
                        90: 'normal'
                    }
                });
                
                $gaugeAlmoco = $('#payloadGaugeAlmoco').dynameter({
                    label: 'FOME',
                    value: Math.trunc(pa),
                    unit: '%',
                    min: 0,
                    max: 100,
                    regions: {
                        0: 'normal',
                        50: 'warn',
                        80: 'error'
                    }
                });
                
                <?php
                        $ano_= date("Y"); 
                        foreach(dias_feriados($ano_) as $a)
                        {
                            // Usa a função criada e pega o timestamp das duas datas:
                            $time_inicial = geraTimestamp(date("d/m/Y"));
                            $time_final = geraTimestamp(date("d/m/Y", $a));
                            // Calcula a diferença de segundos entre as duas datas:
                            $diferenca = $time_final - $time_inicial; // 19522800 segundos
                            // Calcula a diferença de dias
                            $dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
                            // Exibe uma mensagem de resultado:
                            if ($dias > 0 && $dias < 6){ ?>
                                
                                $gaugeFeriado = $('#payloadGaugeFeriado').dynameter({
                                    label: '<?php echo $feriados_label[date("Ymd", $a)]; ?>',
                                    value: <?php echo $dias ; ?>,
                                    unit: '<?php echo ($dias == 1 ? 'dia' : 'dias' ); ?> feriado',
                                    min: 5,
                                    max: 0
                                });
                                                                
                            <?php break; }						 
                        }
                ?>

               $('.progress-bar').removeClass('progress-bar-success');
               $('.progress-bar').removeClass('progress-bar-info');
               $('.progress-bar').removeClass('progress-bar-warning');
               $('.progress-bar').removeClass('progress-bar-danger');

               if( p >= 90 ){
                  $('.progress-bar').addClass('progress-bar-success');
               }
               if( p < 90 ){
                  $('.progress-bar').addClass('progress-bar-info');
               }
               if( p < 50 ){
                  $('.progress-bar').addClass('progress-bar-warning');
               } 
               if( p < 25 ){
                  $('.progress-bar').addClass('progress-bar-danger');
               }

               if( Math.round(p) == 100 ){
                  $('.progress-bar .icon').removeClass('working')
                  $('.progress-bar .icon').addClass('beer')
               }

               $('.list-group-item.porc').html(Math.round(p)+'% concluido');
              
               $('.progress-bar').css('width',p+'%')
           } 

        </script>
        
        <script>
            //Google Analiticts
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-97592513-1', 'auto');
          ga('send', 'pageview');

        </script>

    </head>

    <style type="text/css">
      .main{        
        margin: 50px;
        margin-left: auto;
        margin-right: auto;

        box-shadow: 2px 2px 20px #888888;
      }

      #Clock{
        font-weight: bold;
      }

      .progress{
        height: 50px;   
        margin-bottom: 0px;    
      }

      .progress-bar .icon{
        width: 40px;
        height: 40px;
        margin-left: auto;
        margin-right: auto;
        margin-top: 5px;        
      }

      .progress-bar .icon.working{
        background-image: url('men_at_work.gif');
      }

      .progress-bar .icon.beer{
        background-image: url('loading-beer_2.gif');
        background-position: -100px -70px;
        background-size: 240px ;
      }


      #config{
        cursor: pointer;
      }

      body{
        background: #ccc;
      }
      
      .restante {
          font-family: Arial;
          text-align: center;
          font-size: 28px;
          font-weight: bold;
      }

    </style>

    <body onload="atualizaContador();Horario()">

    <div class="container">
     <div class="row">
        <div class="col-md-12">
        <div class="panel panel-primary main">
          <div class="panel-heading">Contagem regressiva 
            <div class="nav navbar-nav navbar-right" style="margin-right: 5px; margin-top: -10px;"> 
              <h4 class="glyphicon glyphicon-cog" id='config'></h4>
            </div>
          </div>
          <div class="panel-body">

            <ul class="list-group">
              <li class="list-group-item">Fim do expediente: <b class="end">17:45</b> </li>
              <li class="list-group-item">Hora atual: <span id="Clock">00:00:00</span></li>
              <li class="list-group-item restante">Faltando: <span id="contador"></span></li>
              <li class="list-group-item">

                <div class="progress">
                  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                    <div class='icon working'></div>
                    
                  </div>
                </div>
              </li>
              <li class="list-group-item porc"></li>
              <li class="list-group-item meter">
                       <div class="row">
                        <div class="col-sm-3">
                          <div class="form-group">
                            <div id="payloadGaugeCansaco" style="margin: 10 auto;"></div>
                          </div>  
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <div id="payloadGaugeAlmoco" style="margin: 10 auto;"></div>
                          </div>  
                        </div>                        
                        <div class="col-sm-3">
                          <div class="form-group">
                            <div id="payloadGaugeMotivacao" style="margin: 10 auto;"></div>
                          </div>  
                        </div>
                        <div class="col-sm-3">
                          <div class="form-group">
                            <div id="payloadGaugeFeriado" style="margin: 10 auto;"></div>
                          </div>  
                        </div>                        
                       </div>
              </li>
              <li class="list-group-item show-pacman" style="text-align: center">
              	<a id="btn-pacman" href="#"><img src="pacman.png" height="45"></a>
              	<a id="btn-tetris" href="#"><img src="icon-tetris.svg" height="45"></a>
              	<a id="btn-bombergirl" href="#"><img src="img/favicon.ico" height="45"></a>
                <a id="btn-racer" href="#"><img src="racer.png" height="45"></a>
              </li>
            </ul>            
          </div>
       </div>
        </div>
        </div>
        </div>
       
       <div class="modal fade" tabindex="-1" role="dialog" id='pacman'>
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pacman</h4>
              </div>
              <div class="modal-body">
                <iframe id="frmPacman" align="center" width="556px" frameborder="0" scrolling="no" height="556px" src="pacman.php"></iframe>
                <?php //include "pacman.php"; ?>
              </div>              
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <div class="modal fade" tabindex="-1" role="dialog" id='tetris'>
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tetris</h4>
              </div>
              <div class="modal-body">
                <iframe id="frmTetris" align="center" width="100%" frameborder="0" scrolling="no" height="73%" src="tetris.php"></iframe>
                <?php //include "tetris.php"; ?>
              </div>              
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
        <div class="modal fade" tabindex="-1" role="dialog" id='bombergirl'>
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Bomber Girl</h4>
              </div>
              <div class="modal-body">
                <iframe id="frmBomberGirl" align="center" width="100%" frameborder="0" scrolling="no" height="73%" src="bombergirl.php"></iframe>
                <?php //include "bombergirl.php"; ?>
              </div>              
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id='racer'>
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Racer</h4>
              </div>
              <div class="modal-body">
                <iframe id="frmRacer" align="center" width="640px" frameborder="0" scrolling="no" height="480px" src="racer/v4.final.html"></iframe>                
              </div>              
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
       
        <div class="modal fade" tabindex="-1" role="dialog" id='myModal'>
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Configurações</h4>
              </div>
              <div class="modal-body">
                <p>
                    <div class="row">
                    <div class="col-xs-3">
                      <div class="form-group">
                        <label for="hora">Entrada</label>
                        <input type="text" class="form-control" id="entrada" placeholder="Entrada">
                      </div>
                    </div>  
                    <div class="col-xs-3">
                      <div class="form-group">
                        <label for="hora">Saída</label>
                        <input type="text" class="form-control" id="saida" placeholder="Saída">
                      </div>
                    </div>
                    <div class="col-xs-3">
                      <div class="form-group">
                        <label for="hora">Almoço</label>
                        <input type="text" class="form-control" id="almoco" placeholder="Almoço">
                      </div>
                    </div>                    
                    </div>
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id='save'>Save changes</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->               
    </body>

</html>

