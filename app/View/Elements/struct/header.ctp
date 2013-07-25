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
					"&nbsp;",
					"/",
					array("class" => "brand", "escape" => false)
				);
			?>
			
			<ul class="nav">
				<?php $uri = $this->params->controller."_".$this->params->action; ?>

				<?php if ( $this->params["prefix"] == "admin" ): ?>
					<li class="<?php echo ($uri == "users_admin_index") ? "active" : "" ; ?>">
						<?php
							echo $this->Html->link('<i class="icon-white- icon-user"></i> Users', "/admin/users/index", array(
								"escape" => false
							));
						?>
					</li>
					<li class="<?php echo ($uri == "vars_admin_index") ? "active" : "" ; ?>">
						<?php
							echo $this->Html->link('<i class="icon-white- icon-comment"></i> Variables', "/admin/vars/index", array(
								"escape" => false
							));
						?>
					</li>
				<?php else: ?>
					<li class="<?php echo ($uri == "projects_index") ? "active" : "" ; ?>">
						<?php
							echo $this->Html->link('<i class="icon-white- icon-flag"></i> Projects', "/projects", array(
								"escape" => false
							));
						?>
					</li>
				<?php endif; ?>
			</ul>
			
			<ul class="nav pull-right">
			<?php if ( $this->params["prefix"] != "admin" ): ?>
				<li>
					<?php
						echo $this->Html->link('<i class="icon-white- icon-share-alt"></i> Resource Guide', "http://fairhousingmn.org/", array(
							"escape" => false
						));
					?>
				</li>
			<?php endif; ?>
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
					<?php if (AuthComponent::user("admin")): ?>
						<?php if ( $this->params["prefix"] == "admin" ): ?>
							<li>
								<?php
									echo $this->Html->link('<i class="icon-white- icon-share-alt"></i> Get out of Admin Area', "/", array(
										"escape" => false
									));
								?>
							</li>
						<?php else: ?>
							<li>
								<?php echo $this->Html->link('<i class="icon-wrench"></i> Admin', "/admin/users", array("escape" => false)); ?>
							</li>
						<?php endif; ?>
					<?php endif; ?>
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
			</ul>
		</div>
	</div>
</div>