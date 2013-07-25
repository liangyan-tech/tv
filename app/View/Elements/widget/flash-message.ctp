<div class="alert alert-<?php echo isset($type) ? $type : ""; ?> text-center bc-box-shadow opacity95">
	<a class="close" data-dismiss="alert">×</a>
	<?php echo $this->Session->flash("flash"); ?>
</div>