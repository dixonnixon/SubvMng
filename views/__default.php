<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<?php echo $this->header;?>
    <title>Відділ Видатків</title>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navagation">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<div id="navbar" class="navbar-collapse collapse MainMenu">
			<ul class="nav navbar-nav">
				<li><a href="">
					<span aria-hidden="true"></span> Зведена Інформація</a>
				</li>
				<li><a href="{$URL}{$depView}">
					<span aria-hidden="true"></span> Список управлінь області</a> 
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				
			</ul>
		</div>
	</nav>
	<div class="container">
	<?php echo $this->body;?>
	</div>
	<?php echo $this->footer;?>
</body>
</html>