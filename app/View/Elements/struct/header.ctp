<div class="navbar navbar-fixed-top navbar-inverse-">
	
	<?php echo $this->Session->flash("flash", array("element" => "widget/flash-message") ); ?>
	
	<!-- ajax populated alert -->
	<div class="ajax-message hide alert text-center bc-box-shadow opacity95">
		<a class="close" data-dismiss="alert">×</a>
		<div class="text"></div>
	</div>
	<!-- ajax populated alert -->
	
	<div class="navbar-inner">
		<div class="container">
			<?php
				echo $this->Html->link(
					"Sanders' TV Scraper",
					"/",
					array("class" => "brand", "escape" => false)
				);
			?>
			
			<ul class="nav">
				<?php $uri = $this->params->controller."_".$this->params->action; ?>

				<li class="<?php echo ($uri == "diffs_index") ? "active" : "" ; ?>">
					<?php
						echo $this->Html->link('<i class="icon-white- icon-adjust"></i> Diffs', "/diffs", array(
							"escape" => false
						));
					?>
				</li>
				<li class="<?php echo ($uri == "channels_index") ? "active" : "" ; ?>">
					<?php
						echo $this->Html->link('<i class="icon-white- icon-list-alt"></i> Channels', "/channels", array(
							"escape" => false
						));
					?>
				</li>
			</ul>
			
<!-- 			<ul class="nav pull-right">
				<li class="dropdown">
					<?php
						echo $this->Html->link(
							'<i class="icon-white- icon-user"></i> '.AuthComponent::user("name").' <b class="caret"></b>',
							"#",
							array(
								"escape" => false,
								"data-toggle" => "dropdown",
								"class" => "dropdown-toggle"
							)
						);
					?>
					<ul class="dropdown-menu">
						<li>
							<?php
								echo $this->Html->link(
									'<i class="icon-pencil"></i> Edit account',
									"/users/edit/".AuthComponent::user("id"),
									array("escape" => false, "data-toggle" => "modal", "data-target" => "#user-modal")
								);
							?>
						</li>
						<li>
							<?php echo $this->Html->link("<i class='icon-eject'></i>  Log out", "/logout", array("escape" => false)); ?>
						</li>
					</ul>
				</li>
			</ul> -->

		</div>
	</div>
</div>