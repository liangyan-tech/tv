<?php $modal_ids = array("user-modal"); ?>

<?php foreach ($modal_ids as $modal_id): ?>
	<div id="<?php echo $modal_id; ?>" class="modal hide fade in loading" data-original-html='
		<div class="progress progress-striped active">
			<div class="bar" style="width: 100%;"></div>
		</div>
	'>
		<div class="progress progress-striped active">
			<div class="bar" style="width: 100%;"></div>
		</div>
	</div>
<?php endforeach; ?>