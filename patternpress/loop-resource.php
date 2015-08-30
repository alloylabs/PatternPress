<?php
/**
 * The loop that displays a single post.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop-single.php.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.2
 */
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	<div class="row">
  		<div class="col-xs-12">           		
			<h2><?php the_title(); ?></h2>
			<?php if($post->post_content != "") { the_content(); }?>
			<br/><pre><code><?php
$string = htmlspecialchars(get_post_meta($post->ID, "include", true), ENT_QUOTES, "UTF-8");
echo $string;?></code></pre>
		</div>
	</div>
	

<?php endwhile; // end of the loop. ?>