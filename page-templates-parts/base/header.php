<header id="header" class="" role="header">
	
	<nav role="navigation">
		<ul>
		<?php
			wp_nav_menu( array(
				'theme_location' 	=> 'main-menu',
				'container'			=> '',
				'menu_class' 		=> 'menu main-menu menu-depth-0 menu-even',
				'echo' 				=> true,
				'items_wrap'		=> '%3$s',
				'depth'         	=> 3,
				'walker'        	=> new fluxi_walker_nav_menu
			) );
		?>
		</ul>		
	</nav>

</header>