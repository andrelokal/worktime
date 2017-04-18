<?php
ini_set('short_open_tag','1');
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Idleness Systems</title>
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
  var $totalDaysOfWeek;
  var HE;
  var ME;
  var HS;
  var MS;
  var MT;  

  var HH;
  var MI;
  var SS;
  
  var HA;
  var MA;
  var AT;

  $( function() {
   
   Init()

    $("#progressbar").progressbar({value: 0});

    $('#saida,#entrada,#almoco').mask( '99:99' );

    $('#config').click(function(){
      $('#myModal').modal()
    })

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

                var faltam = '';

                faltam += (toString(hh).length) ? hh+' hr, ' : '';

                faltam += (toString(mm).length) ? mm+' min e ' : '';

                faltam += ss+' seg';

                if (dd+hh+mm+ss > 0) {

                    if ($totalDaysOfWeek == 0) {
                        faltam = 'Falta nada!!! Fim de semana caralho!!!';
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
               
               if ($totalDaysOfWeek == 0) {
                   p = 100;
                   $totalDaysOfWeek = 1;
                   var $multiply = 0;
               }else{
                   var $multiply = 1;
               }
               
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
                    value: Math.round(100 / $totalDaysOfWeek),
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
              <li class="list-group-item">Faltam: <span id="contador"></span></li>
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
                        <div class="col-sm-4">
                          <div class="form-group">
                            <div id="payloadGaugeCansaco" style="margin: 10 auto;"></div>
                          </div>  
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                            <div id="payloadGaugeAlmoco" style="margin: 10 auto;"></div>
                          </div>  
                        </div>                        
                        <div class="col-sm-4">
                          <div class="form-group">
                            <div id="payloadGaugeMotivacao" style="margin: 10 auto;"></div>
                          </div>  
                        </div>  
                       </div>
              </li>
            </ul>            
          </div>
       </div>
        </div>
        </div>
        </div>
       
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

