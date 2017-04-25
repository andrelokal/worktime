var showchat = true;

function callchat() {
	$('#chat').remove();
	$('body').append( "<div id='chat'><iframe width=100% height=100% frameborder=0 src='chat/' framescroll='no' ></iframe></div>" )
	var css = {	position: 'absolute',
				bottom: '0px',
				width: '250px',
				height: '250px',
				right: '0px'}

	$('#chat').css(css);
}

function closechat() {
	$('#chat').remove();	
}

$(function(){
	callchat();

})