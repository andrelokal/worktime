
<?php
include_once('util/config.php');
include_once('model/Emogi.php');
?>
<script>
    //Google Analiticts
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-97592513-1', 'auto');
  ga('send', 'pageview');

</script>
<!DOCTYPE html>
<html>
<head>
    <style type="">
    
        #emotions{
            background: url('images/smile.png');
            background-repeat: no-repeat;
            width: 20px;
            height: 20px;            
        } 
    
        #emotions img{
            display: none;
        }
                
    </style>
    <title>Chat</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>  
    <script>

        $( function() {
            
            $("#button").click(function(){
                sendMessage();
            });
            
            
            $('#texto').keydown(function(e){
                if(e.which == 13){
                    sendMessage();
                    return false;    
                }  
                $('#emotions').css('width','20px')
                $('#emotions').find('img').css('display','none')
                  
            });
            
            
            $("#sair").click(function(){
                $.post("control/usuarioController.php", "action=4" , function(){
                    location.href = 'index.php';
                });
            });
            
            $('#emotions img').click(function(){
                var word = $(this).attr('word');
                $('#texto').val( $('#texto').val() + " "+word );
                $('#texto').focus();
                
            })
            
            $('#emotions').click(function(){                
                $(this).css('width','100%')
                $(this).find('img').css('display','inline')
            })
             
        });

        function sendMessage(){
            var data = $( '#form').serializeArray();

            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: { 'form':data },  
                url: "<?php echo 'control/usuarioController.php'; ?>", 
                success: function(result){
                    ChargerBox( true );                    
                    
            }});

            $('#texto').val('');
            $('#texto').focus();
        }

        function NewMessage( text ){
            if( !$('#NewMessage').lenght ){
                $('#NewMessage').remove();
                $('#form').append("<div id='NewMessage'>"+text+"</div>")
                $('#NewMessage').unbind('click').click(function(){
                    
                    GottoDown()
                    $('#NewMessage').remove()
                })
            }
            
        }

        function GottoDown(){
            var alt = $('#content').innerHeight()
            var h = $('#content').prop('scrollHeight');
            var st = $('#content').scrollTop();

            last = h;                    
            $('#content').scrollTop( h );
        }

        var time = 0;
        var timer = 2;

        function crono(){
            time++;
            if( time >= timer ){
                ChargerBox()
            }
            
            setTimeout(crono,1000);
        }


        var position = 0;
        var last = 0;
        var last_len = 0;
        var last_hour = 0;
        var last_hour2 = 0;
        var last_msg = '';
        var last_nome = '';
        function ChargerBox( gotodown ){
            
            var h = $('#content').prop('scrollHeight');
            var st = $('#content').scrollTop();
            position = Math.round(h - st);
            var nummsg = 0;
            
            time = 0;  
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: { 'action':'3' },  
                url: "<?php echo 'control/usuarioController.php'; ?>", 
                success: function(result){

                    $("#content").html('')
                    for( var i in result ){
                        
                        var color = '#000000';
                        
                        if(result[i].cor){
                           color = result[i].cor; 
                        }
                            
                            
                            
                            if(result[i].nome == '<?php echo $_SESSION['nome']; ?>'){
                                $("#content").append("<div style='background: #E5E1EB'>"+result[i].hora +' [<span style="color: '+ color +'"><b>'+ result[i].nome +'</b></span>] diz: ' + result[i].texto + "</div>");    
                            }else{
                                $("#content").append("<div style='background:#FFFFFF '>"+result[i].hora +' [<span style="color: '+ color +'"><b>'+ result[i].nome +'</b></span>] diz: ' + result[i].texto + "</div>");    
                            }
                        
                        last_hour = result[i].hora;
                        last_msg = result[i].texto;
                        last_nome = result[i].nome;    
                    }
                    
                    if(last_hour != last_hour2){
                        if($('#notify').is(':checked')){
                            //notifyMe(last_nome,last_msg,'chatting.png');
                            notifyMe(last_nome,'Enviou uma Nova Mensagem','chatting.png');    
                        }
                        last_hour2 = last_hour;    
                    }
                    
                                        
                    var alt = $('#content').innerHeight()
                    var h = $('#content').prop('scrollHeight');

                    if( gotodown ){
                      $('#content').scrollTop( h ); 
                      last = h; 
                    } 

                    var st = $('#content').scrollTop();
                    if(position == alt ){
                        last_len = result.length;
                        last = h;
                        position = Math.round(h - st);
                        $('#content').scrollTop( h );
                        $('#NewMessage').remove()
                    } else {
                        if( Number(h) != Number(last) ){
                            nummsg = Number(result.length) - Number(last_len);
                            NewMessage( "("+nummsg+") Novas" );
                        }
                        position = Math.round(h - st)    
                    }


                //teste();    
                    
                    
            }});
        }

        function notifyMe(titleMsg,bodyMsg,iconAlert) {
            
            if(document.hasFocus() == false){
                
                  // Let's check if the browser supports notifications
                  if (!("Notification" in window)) {
                    //alert("This browser does not support desktop notification");
                  }

                  // Let's check whether notification permissions have already been granted
                  else if (Notification.permission === "granted") {
                    // If it's okay let's create a notification
                                var notification = new Notification(titleMsg, {
                                    dir: 'ltr',
                                    body: bodyMsg,
                                    icon: iconAlert
                                })
                  }

                  // Otherwise, we need to ask the user for permission
                  else if (Notification.permission !== 'denied') {
                    Notification.requestPermission(function (permission) {
                      // If the user accepts, let's create a notification
                      if (permission === "granted") {
                                var notification = new Notification(titleMsg, {
                                    dir: 'ltr',
                                    body: bodyMsg,
                                    icon: iconAlert
                                })
                      }
                    });
                  }

                  // At last, if the user has denied notifications, and you 
                  // want to be respectful there is no need to bother them any more.
                
            }

        }

        
        
        
        
        
        
    </script>
</head>
<body onload="ChargerBox(); crono();">
<div id="content" ></div>
<form method="post" id="form">
    <div>
        <input type="hidden" name="action" value="2" />
        <input type="text" name="texto" id="texto" />
    </div>
    <div style="width: 100px; float: left">
        <input type="checkbox" id="notify" name="notify" value="1" title="notificar mensagens">
        <input type="button" id="button" value="Enviar">
        <input type="button" id="sair" value="sair">
    </div>
    <div style="float: left" id='emotions'>
        <?php                                
            $emogi = new Emogi();
            echo $emogi->getEmogi(':):D(A)lalala(!)(t+):S(Y)(N)zzz:P8Do0(palmas):@(ran)(yeah)_|_;(kkk(dah):(:|*_*(rage)s2(heart_eyes)(kissing_heart)(pensive)(flushed)');
        ?>
    </div>
    
    
</form>

</body>
</html>

