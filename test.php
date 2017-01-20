<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="author" content="Sean Nieuwoudt" />
	<meta name="robots" content="all" />
	<title>jQuery Popdown Plugin Demo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link rel="stylesheet" href="/jquery-popdown/css/jquery.popdown.css">

	<style>
		body, html{
			background-color:#EEEEEE;
			font-family: Georgia, Times, "Times New Roman", serif;
			font-size:26px;
			text-align:center;
		}
		a{
			color:#00A0C6;
		}
		a:hover{
			color:#13819b;
		}
		h1{
			font-family: "Helvetica Neue", Helvetica, "pragmatica-web", Arial, sans-serif;
			font-size:33px;
			color:#727272;
			padding-top:0px;
			margin-top:0;
		}
		.contain p{
			display:block;
			margin:0 auto;
			max-width:720px;
			color:#B3B3B1;
			padding: 10px;
			line-height: 1.4em;
			padding-bottom:50px;
		}
		p a.btn{
			display:inline-block;
			border:4px solid #d8d8d8;
			color:#d1d1d1;
			text-decoration:none;
			padding:10px;
			margin-bottom: 20px;
		  	-webkit-border-radius: 5px;
		  	-moz-border-radius: 5px;
		  	border-radius: 5px;
		  	-moz-transition-duration: 0.2s;
		  	-webkit-transition-duration: 0.2s;
		  	-o-transition-duration: 0.2s;
		  	transition-duration: 0.2s;
		}
		p a.btn:hover{
			color:#F7656A;
			border:4px solid #F7656A;
		}
		a.logo{
			display:block;
			text-indent:-9999px;
			background:url(/jquery-popdown/img/wixel.png) no-repeat;
			width:33px;
			height:33px;
			margin:50px auto;
		}
		div.share{
			text-align:center;
		}
		.small-text{
			font-size:13px;
		}
		@media only screen and (min-width: 480px){
			h1{
				font-size: 66px;
			}
			a.logo{
				margin:100px auto;
			}
		}
	</style>
</head>
<body class="demo-page">

	<a href="http://wixelhq.com" class="logo" title="Wixel - A custom software development studio">Wixel - A custom software development studio</a>

	<h1>jQuery Popdown Plugin</h1>

	<section class="contain">
		<p>
			Sometimes you just need a little popdown to spice up your interface. Here are a few examples:
		</p>

		<p>
			<a href="/jquery-popdown/pages/image.html" class="popdown btn" title="Grumpy Demo">Grumpy Demo</a>
			<a href="/jquery-popdown/pages/youtube.html" class="popdown btn" title="Youtube Demo">Youtube Demo</a>
			<a href="/jquery-popdown/pages/content.html" class="popdown btn" title="Content Demo">Content Demo</a>
		</p>

		<p>
			<img src="/jquery-popdown/img/browsers.png" alt="Testing on IE, FireFox, Chrome &amp; Safari">
		</p>

		<p class="small-text">
			Please <a href="https://twitter.com/intent/tweet?hashtags=javascript&original_referer=http%3A%2F%2Fwixel.github.io%2Fjquery-popdown&related=SeanNieuwoudt&text=Awesome%20jQuery%20Popdown%20Plugin&tw_p=tweetbutton&url=http%3A%2F%2Fwixel.github.io%2Fjquery-popdown&via=Wixelhq">share on Twitter</a>
			 or <a href="http://github.com/Wixel/jquery-popdown">download</a> over at Github.
		</p>
	</section>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script type="text/javascript" src="/jquery-popdown/lib/jquery.popdown.js?v=1" /></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('.popdown').popdown();
		});
	</script>

</body>
</html>