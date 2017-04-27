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
                    ChargerBox();
                    
            }});

            $('#texto').val('');
            $('#texto').focus();
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
        function ChargerBox(){
            
            var h = $('#content').prop('scrollHeight');
            var st = $('#content').scrollTop();
            position = Math.round(h - st);
            
            
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
                    var st = $('#content').scrollTop();
                    if(position == alt ){
                        position = Math.round(h - st);
                        $('#content').scrollTop( h );
                    } else {
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

