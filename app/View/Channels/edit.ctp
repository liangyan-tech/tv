<?php if (!$this->request->is("ajax")): ?><div id="var-modal" class="modal fade in loading-"><?php endif; ?>

<?php
	echo $this->Form->create("Channel", array(
		"class" => "form-horizontal",
		"id" => "channel-edit",
		"url" => array(
			"controller" => "channels",
			"action" => "edit",
			$id
		),
		"inputDefaults" => array(
			"label" => false,
			"div" => false,
			"class" => "input-medium"
		)
	));
	// echo $this->Form->hidden("id", array("value" => $channel["Channel"]["id"]));
?>

<div class="modal-header">
	<a class="close" data-dismiss="modal">×</a>
	<h3><?php echo $title_for_layout; ?></h3>
</div>

<div class="modal-body">
	<div class="control-group">
		<label class="control-label">Channel Name</label>
		<div class="controls">
			<?php 
				echo $this->Form->input("channel", array(
					"class" => "input-xlarge",
					"value" => ((isset($channel) && $channel) ? $channel["Channel"]["channel"] : "")
				));
			?>
			<p class="help-inline validation-message"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Vendor</label>
		<div class="controls">
			<?php 
				echo $this->Form->input("vendor", array(
					"class" => "input-medium",
					"value" => ((isset($channel) && $channel) ? $channel["Channel"]["vendor"] : "")
				));
			?>
			<p class="help-inline validation-message"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Package</label>
		<div class="controls">
			<?php 
				echo $this->Form->input("package", array(
					"class" => "input-medium",
					"value" => ((isset($channel) && $channel) ? $channel["Channel"]["package"] : "")
				));
			?>
			<p class="help-inline validation-message"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Tag</label>
		<div class="controls">
			<?php 
				echo $this->Form->input("tag", array(
					"class" => "input-medium",
					"value" => ((isset($channel) && $channel) ? $channel["Channel"]["tag"] : "")
				));
			?>
			<p class="help-inline validation-message"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Position</label>
		<div class="controls">
			<?php 
				echo $this->Form->input("position", array(
					"class" => "input-medium",
					"value" => ((isset($channel) && $channel) ? $channel["Channel"]["position"] : "")
				));
			?>
			<p class="help-inline validation-message"></p>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label">Vendor</label>
		<div class="controls">
			<?php 
				echo $this->Form->input("vendor", array(
					"class" => "input-medium",
					"value" => ((isset($channel) && $channel) ? $channel["Channel"]["vendor"] : "")
				));
			?>
			<p class="help-inline validation-message"></p>
		</div>
	</div>
</div>

<div class="modal-footer">
	<?php
		$submitOptions = array( 
			"class" => "btn btn-primary btn-large", 
			"div" => false
		);
		$submitText = "Save changes";
	?>
	<a href="#" class="btn pull-left" data-dismiss="modal">Cancel</a>
	<?php echo $this->Form->submit($submitText, $submitOptions); ?>
</div>

<?php echo $this->Form->end(); ?>

<?php if (!$this->request->is("ajax")): ?></div><?php endif; ?>