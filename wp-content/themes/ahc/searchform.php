<div id="search">
	<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
		<div class="input">
			<input type="text" value="" name="s" class="s">
		</div>
		<div class="btn">
			<input type="image" id="searchsubmit" value="検索" src="<?php assets_dir();?>images/common/btn_search.png">
		</div>
	</form>
</div>