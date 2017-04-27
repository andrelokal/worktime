<?php
include_once('util/config.php');
?>
<!DOCTYPE html>
<html>
<head>
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
            });
            
            
            $("#sair").click(function(){
                $.post("control/usuarioController.php", "action=4" , function(){
                    location.href = 'index.php';
                });
            });
            
             
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
                        if(result[i].nome == '<?php echo $_SESSION['nome']; ?>'){
                            $("#content").append("<div style='background: #E5E1EB'>"+result[i].hora +' [<b>'+ result[i].nome +'</b>] diz: ' + result[i].texto + "</div>");    
                        }else{
                            $("#content").append("<div style='background:#FFFFFF '>"+result[i].hora +' [<b>'+ result[i].nome +'</b>] diz: ' + result[i].texto + "</div>");    
                        }
                            
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
                            NewMessage( "("+nummsg+") Novas" )
                        }
                        position = Math.round(h - st)    
                    }


                    
                    
                    
            }});
        }
    </script>
</head>
<body onload="ChargerBox(); crono();">
<div id="content" ></div>
<form method="post" id="form">
    <input type="hidden" name="action" value="2" />
    <input type="text" name="texto" id="texto" />
    <input type="button" id="button" value="Enviar">
    <input type="button" id="sair" value="sair">
</form>

</body>
</html>

