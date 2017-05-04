<script>
    //Google Analiticts
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-97592513-1', 'auto');
  ga('send', 'pageview');

</script>
<?php
include_once('util/config.php');

?>


<link href="chat.css" rel="stylesheet" type="text/css" />

<?php

if(@$_SESSION['sala']){
    include_once('view/formChat.php');
    //header('Location: '.PATH.'view/formChat.php');
}else{
    include_once('view/formLogin.php');
    //header('Location: '.PATH.'view/formLogin.php');    
}
    
?>