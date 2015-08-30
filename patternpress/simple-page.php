<?php
/*
Template Name: Simple Page
*/
get_header(); ?>

    <div id="container">
      <div id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

  <div class="row">
  <div class="col-xs-12">               
      <h2><?php the_title(); ?></h2>
      <?php if($post->post_content != "") { the_content(); }?>
     
    </div>
  </div>
  

<?php endwhile; // end of the loop. ?>

      </div><!-- #content -->
    </div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
