<!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title>
			<?php echo $title_for_layout; ?> | AFMT
		</title>
		<?php
			echo $this->Html->meta('icon');
			echo $this->Html->css(array(
				"/bootstrap/css/bootstrap.min.css",
				"bootstrap-mod"
			));
			if (file_exists(WWW_ROOT.DS."css".DS.$this->params["controller"].".css")) echo $this->Html->css($this->params["controller"]);
			if (file_exists(WWW_ROOT.DS."css".DS.$this->params["controller"]."-".$this->params["action"].".css")) echo $this->Html->css($this->params["controller"]."-".$this->params["action"]);
			
			echo $this->Html->script(array(
				'//ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.min.js',
				"underscore-min.js",
				'//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js',
				'jquery.form.js',
				"/bootstrap/js/bootstrap.min.js",
				"app.common"
			));
			echo $this->fetch('meta');
			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
		<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<?php echo $this->Html->script("html5shiv"); ?>
		<![endif]-->
	</head>
	
	<body class="<?php echo $this->params->controller; ?>">
		
		<div class="navbar navbar-fixed-top">
			<?php if ($authMessage = $this->Session->flash('auth')): ?>
				<div class="alert alert-error text-center bc-box-shadow opacity90">
					<a class="close" data-dismiss="alert">×</a>
					<?php echo $authMessage; ?>
				</div>
			<?php else: ?>
				<?php echo $this->Session->flash("flash", array("element" => "widget/flash-message") ); ?>
			<?php endif; ?>
			
			<div class="navbar-inner">
				<div class="container-narrow">
					<div class="brand">
						
					</div>
				</div>
			</div>
		</div>

		<div class="container-narrow">
			<div id="content" class="row">
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<?php echo $this->element("struct/footer");?>
		
		<?php if (isset($_GET["sql"])) echo $this->element('sql_dump'); ?>
	</body>
</html>