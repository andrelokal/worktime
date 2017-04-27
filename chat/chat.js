var showchat = false;

function callchat() {
	$('#chat').remove();
	$('body').append( "<div id='chat'><div class='header'><div style='padding-right:5px; cursor:pointer'>Fechar</div></div><iframe width=100% height=95% frameborder=0 src='chat/' framescroll='no' ></iframe></div>" )
	var css = {	position: 'absolute',
				bottom: '0px',
				width: '250px',
				height: '250px',
				right: '0px',
                'border-radius': '5px',
                'background-color': '#337AB7',
                'z-index': '10000'}
    
    $('#chat .header').css({  'color':'FFFFFF'})
    $('#chat .header div').css({'float':'right'}).click(function(){
        closechat();
    })

	$('#chat').css(css);    
    $( "#chat" ).draggable();
    $( "#chat" ).resizable();
    
}

function closechat() {
	$('#chat').remove();	
}

$(function(){
	closechat();

})