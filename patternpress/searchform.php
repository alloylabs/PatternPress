<form action="<?php echo home_url( '/' ); ?>" method="get">
	<fieldset>
		<input type="text" name="s" id="search" placeholder="Search Patterns" value="<?php the_search_query(); ?>" />
		<button class="btn" alt="Search"><i class="fa fa-search"></i></button>
	</fieldset>
</form>