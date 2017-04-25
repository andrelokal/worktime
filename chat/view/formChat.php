<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
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


        function ChargerBox(){
            
            time = 0;  
            $.ajax({
                type: "POST",
                dataType: "JSON",
                data: { 'action':'3' },  
                url: "<?php echo 'control/usuarioController.php'; ?>", 
                success: function(result){
                    
                    $("#content").html('')
                    for( var i in result ){
                        $("#content").append("<div>"+result[i].hora +' ['+ result[i].nome +'] diz: ' + result[i].texto + "</div>")    
                    }
                    var h = $('#content').innerHeight() + 800
                    $('#content').scrollTop( h )
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

