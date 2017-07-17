<?php if( is_user_logged_in() ): ?>
	<div class="cb-adminTools js-adminBar">
		<div class="cb-adminTools__area is-none">
			<button class="cb-adminTools__area__bt is-none js-toggle-grid">Show Grid</button>
		</div>

		<div class="cb-adminTools__area">
			<a href="<?php bloginfo('url'); ?>/wp-admin/" target="_blank" class="cb-adminTools__area__bt">Admin</a>
			<a href="<?php echo get_edit_post_link(get_the_ID()); ?>" target="_blank" class="cb-adminTools__area__bt">Edit</a>
		</div>

		<div class="cb-adminTools__area is-none">
			<button class="cb-adminTools__area__bt js-close-adminBar">Hide</button>
		</div>
	</div>
<?php endif; ?>