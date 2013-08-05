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
	<h2>Diffs <small>Changes between the last two scrapes, last scraped at <?php echo $lastScrape["Scrape"]["created"]; ?></small></h2>
</div>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Vendor</th>
			<th>Package</th>
			<th>Tag</th>
			<th>Channel</th>
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
					<?php echo $lastScrape["Scrape"]["created"]; ?>
				</td>
				<td>
					<a href="#" class="btn btn-primary">Commit changes</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>