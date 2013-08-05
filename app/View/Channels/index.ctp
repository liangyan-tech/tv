<div class="page-header">
	<h2>Channels <small>add, edit or delete a channel</small></h2>
</div>

<table class="table table-condense table-striped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Vendor</th>
			<th>Package</th>
			<th>Tag</th>
			<th>Channel</th>
			<th>Changed</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($channels as $channel): ?>
			<tr>
				<td><?php echo $channel["Channel"]["id"]; ?></td>
				<td><?php echo $channel["Channel"]["vendor"]; ?></td>
				<td><?php echo $channel["Channel"]["package"]; ?></td>
				<td><?php echo $channel["Channel"]["tag"]; ?></td>
				<td><?php echo $channel["Channel"]["channel"]; ?></td>
				<td><?php echo $channel["Channel"]["modified"]; ?></td>
				<td>
					<div class="btn-group">
						<?php
							echo $this->Html->link(
								'<i class="icon-pencil icon-white"></i> Edit',
								"/channels/edit/".$channel["Channel"]["id"],
								array("escape" => false, "class" => "btn btn-primary")
							);
						?>
						<?php
							echo $this->Html->link(
								'<i class="icon-remove icon-white"></i>',
								"/channels/delete/".$channel["Channel"]["id"],
								array("escape" => false, "class" => "btn btn-danger"),
								"This will delete the channel. Are you sure?"
							);
						?>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>