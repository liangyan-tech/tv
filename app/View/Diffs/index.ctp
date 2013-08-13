<style type="text/css">
	ins {
		color: green;
		background: #dfd;
		text-decoration: none;
	}
	del {
		color: red;
		background: #fdd;
		text-decoration: line-through;
	}
</style>

<div class="page-header">
	<h2>Differences <small>Changes between the last two scrapes, last scraped at <?php echo $lastScrape["Scrape"]["created"]; ?></small></h2>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Vendor</th>
			<th>Package</th>
			<th>Tag</th>
			<th>Channel</th>
			<th>Type</th>
			<th>Changed</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($diffs as $diff): ?>
			<tr>
				<td data-new-text="<?php echo $diff["vendor"]["new"]; ?>">
					<?php echo $diff["vendor"]["diff-text"]; ?>
				</td>
				<td data-new-text="<?php echo $diff["package"]["new"]; ?>">
					<?php echo $diff["package"]["diff-text"]; ?>
				</td>
				<td data-new-text="<?php echo $diff["tag"]["new"]; ?>">
					<?php echo $diff["tag"]["diff-text"]; ?>
				</td>
				<td data-new-text="<?php echo $diff["channel"]["new"]; ?>">
					<?php echo $diff["channel"]["diff-text"]; ?>
				</td>
				<td>
					<?php echo $diff["type"]; ?>
				</td>
				<td>
					<?php echo $lastScrape["Scrape"]["created"]; ?>
				</td>
				<td>
					<?php
						echo $this->Html->link(
							"Commit Changes",
							"/diffs/commit/{$diff['type']}/{$diff['modified_according_to']}/{$diff['channel_id']}",
							array(
								"class" => "btn btn-primary"
							),
							"Are you sure you want to commit this change?"
						);
					?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>