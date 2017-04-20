<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  
  <title>Blockrain.js - A Tetris game in HTML5 + Javascript (with autoplay!)</title>

  <meta name="description" content="Blockrain.js lets you embed the classic Tetris game on your website" />
  <meta name="keywords" content="js, jquery, game, plugin, html5, tetris" />
  <meta name="robots" content="INDEX, FOLLOW" />
  <meta name="author" content="Aerolab" />

  <!-- Facebook Stuff -->
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="Blockrain.js" />
  <meta property="og:title" content="Blockrain.js - a Tetris game in HTML5 + Javascript" />
  <meta property="og:description" content="Blockrain.js lets you embed the classic Tetris game on your website" />
  <meta property="og:image" content="http://aerolab.github.io/blockrain.js/assets/images/social-card.png" />
  <meta property="og:url" content="http://aerolab.github.io/blockrain.js" />
  <meta property="fb:app_id" content="344819049029949" />
  
  <!-- Twitter Stuff -->
  <meta property="twitter:card" content="summary" />
  <meta property="twitter:site" content="@aerolab" />
  <meta property="twitter:title" content="Blockrain.js - a Tetris game in HTML5 + Javascript" />
  <meta property="twitter:description" content="Blockrain.js lets you embed the classic Tetris game on your website" />
  <meta property="twitter:image" content="http://aerolab.github.io/blockrain.js/assets/images/social-card.png" />
  <meta property="twitter:url" content="http://aerolab.github.io/blockrain.js" />

  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />
  <link rel="shortcut icon" href="assets/images/favicon.png">

  <link href='http://fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="src/blockrain.css">
	
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
<body>
<section id="examples">

  <article id="example-slider" style="position: absolute; top: 0; bottom: 0; left: 0; right: 0; margin: auto;">
    <div class="example">
      <div class="instructions">
        Use apenas as setas
        <div class="keyboard">
          <div class="key key-up"></div>
          <div class="key key-left"></div>
          <div class="key key-down"></div>
          <div class="key key-right"></div>
        </div>
      </div>
      <div class="game" id="tetris-demo"></div>
    </div>
  </article>

</section>

<script src="assets/js/jquery-1.11.1.min.js"></script>
<script src="src/blockrain.jquery.libs.js"></script>
<script src="src/blockrain.jquery.src.js"></script>
<script src="src/blockrain.jquery.themes.js"></script>

<script>
  var $demo = $('#tetris-demo').blockrain({
    speed: 20,
    theme: 'candy',
    onStart: function() {
      ga( 'send', 'event', 'tetris', 'started');
    },
    onLine: function() {
      ga( 'send', 'event', 'tetris', 'line');
    },
    onGameOver: function(score){
      ga( 'send', 'event', 'tetris', 'over', score);
    }
  });

  function switchDemoTheme(next) {

    var themes = Object.keys(BlockrainThemes);

    var currentTheme = $demo.blockrain('theme');
    var currentIx = themes.indexOf(currentTheme);

    if( next ) { currentIx++; }
    else { currentIx--; }

    if( currentIx >= themes.length ){ currentIx = 0; }
    if( currentIx < 0 ){ currentIx = themes.length-1; }

    $demo.blockrain('theme', themes[currentIx]);
    $('#example-slider .theme strong').text( '"'+themes[currentIx]+'"' );
  }
</script>

</body>
</html>
