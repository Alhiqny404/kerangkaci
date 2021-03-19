<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
					     <?php $i=1; foreach(menu() as $m) : ?>
			            <?php $is=1; foreach (submenu($m['id']) as $sm):?>
								<li><a href="<?=base_url($sm['url']);?>" class=""><i class="<?= $sm['icon'];?>"></i> <span><?=$sm['title'];?></span></a></li>
			            <?php endforeach; ?>
			            <?php endforeach; ?>
						<li><a href="<?=base_url('login/logout');?>" class=""><i class="fas fa-fw fa-sign-out-alt"></i> <span>logout</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->

		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">