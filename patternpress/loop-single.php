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
		<div class="col-lg-12 col-xs-12">            		
			<h2><?php the_title(); ?></h2>
      	</div> 
   	</div>
   	<div class="row">      
        <div class="col-lg-12 col-xs-12">
			<?php if($post->post_content != "") { the_content(); }?>
		    <h4>Live Demo</h4>
<script type="text/javascript">
  function iframeLoaded() {
      var iFrame = document.getElementById('pattern-wrap');
      if(iFrame) {
            iFrame.height = "";
            iFrame.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
      }   
  }
</script>   
			<iframe id="pattern-wrap" onload="iframeLoaded()" src="//<?php echo $_SERVER[HTTP_HOST]; ?>/pps_ux/patterns/pattern-viewer?postid=<?php echo $post->ID; ?>" style="border:1px solid #ddd;padding:15px;width:100%">
			</iframe>
		</div>
	</div>
	<div class="row">      
        <div class="col-lg-12 col-xs-12">
					<nav class="navbar navbar-default navbar-tabs" role="navigation">
		    			<div class="navbar-header">
							<h3 id="current-nav-page" class="selected-nav-item-label">Markup</h3>
							<button type="button" class="navbar-toggle collapsed btn-default" data-toggle="collapse" data-target="#code-nav">
							        <span class="sr-only">Toggle navigation</span>
							        <span class="sch-chevron-small-down-2x"></span>
							</button>
		    			</div>
		    			<div class="collapse navbar-collapse" id="code-nav">
			    			<div role="tabpanel">
					            <ul class="nav nav-tabs" role="tablist">
					              <li role="presentation" class="active"><a href="#markup" aria-controls="home" role="tab" data-toggle="tab">Markup</a></li>
					              <li role="presentation"><a href="#css" aria-controls="home" role="tab" data-toggle="tab">CSS</a></li>
					               <li role="presentation"><a href="#notes" aria-controls="home" role="tab" data-toggle="tab">Notes</a></li>
					            </ul>
							</div>
					</div>
				</nav>
				<div class="tab-content">
	              <div role="tabpanel" class="tab-pane active" id="markup">
<pre><code><?php
$key="html";
$string = htmlspecialchars(get_post_meta($post->ID, $key, true), ENT_QUOTES, "UTF-8");
echo $string;?></code></pre>
	              </div>
	              <div role="tabpanel" class="tab-pane" id="css">
<pre><code><?php
$key="css";
$string = htmlspecialchars(get_post_meta($post->ID, $key, true), ENT_QUOTES, "UTF-8");
echo $string;?></code></pre>
	              </div>
	              <div role="tabpanel" class="tab-pane" id="notes">
					<?php
					$key="notes";
					$string = get_post_meta($post->ID, $key, true);
					echo $string;?>	                
	              </div>
	            </div>		
				</div>
	</div>

<?php endwhile; // end of the loop. ?>