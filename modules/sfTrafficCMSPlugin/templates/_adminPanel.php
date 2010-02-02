        <?php $config = sfConfig::get('sf_cms') ?>
        <div id="admin-panel">
			<div id="admin-bar">
				<div class="left">
					<a href="http://www.trafficdigital.com/" id="admin-logo"></a>
					<a href="#" class="admin-small-button" id="admin-welcome">Welcome Alex</a>
					<a href="#" class="admin-small-button" id="admin-toggle">Admin Panel</a>
					<?php echo link_to('Log out', '@sf_guard_signout', array('class' => 'admin-small-button', 'id' => 'admin-logout')) ?>
				</div>
				<div id="admin-drag-handle"> </div>
				<div class="right">
					<a href="admin-edit-page.html" target="<?php echo $config['edit_link']['attributes']['target'] ?>" class="admin-big-button" id="admin-edit-page">Edit this page</a>
					<a href="#" class="admin-big-button" id="admin-maximise"> </a>
					<a href="#" class="admin-big-button" id="admin-close">Close</a>
				</div>
			</div>
			<div id="admin-edit-area">
				<div id="admin-editor">
					<iframe src ="/backend_local.php/project" width="100%" height="100%" frameborder="0" scrolling="auto" name="<?php echo $config['edit_link']['attributes']['target'] ?>">
					  <p>Your browser does not support iframes.</p>
					</iframe>
				</div>
				<div id="admin-navigation">
					<ul>
						<li><a href="admin-edit-main.html" target="<?php echo $config['edit_link']['attributes']['target'] ?>">Admin Home</a></li>
						<li><a href="#">Articles</a></li>
						<li><a href="#">News Items</a></li>
						<li><a href="#">Staff</a></li>
						<li><a href="#">Publications</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id="admin-panel-spacer"> </div>