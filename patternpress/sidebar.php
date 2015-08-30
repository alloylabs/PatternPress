<?php
$pages = array(
	'theme_location'  => '',
	'menu'            => '',
	'container'       => 'div',
	'container_class' => '',
	'container_id'    => '',
	'menu_class'      => 'menu',
	'menu_id'         => '',
	'echo'            => true,
  'exclude'         => get_option('pattern_page'),
	'fallback_cb'     => 'wp_page_menu',
	'before'          => '',
	'after'           => '',
	'link_before'     => '',
	'link_after'      => '',
	'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	'depth'           => 0,
	'walker'          => ''
);
wp_nav_menu( $pages );
?>
<div class="menu">
<h5>Resources</h5>
  <ul>
<?php

$args=array(
  'post_type' => 'resource',
  'post_status' => 'publish',
  'posts_per_page' => -1) ;

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post(); ?>
    <li class="page_item page-item-<?php echo the_id(); if (get_the_ID()==$wp_query->post->ID){echo" current_page_item";} ?> "><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
    <?php
  endwhile;
}
wp_reset_query();
?>    
</ul>           
</div>                                   