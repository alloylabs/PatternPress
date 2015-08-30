<?php 
/* Template Name: Content Page */
?>
<?php 
$post_id = get_option('pattern_page');
$patternPagePost = get_post($post_id); 
$patternPageSlug = $patternPagePost->post_name;
if ( have_posts() ) while ( have_posts() ) : the_post(); 
?>
<div class="row">
  <div class="col-xs-12">            		
			<h2><?php the_title(); ?></h2>
			<?php if($post->post_content != "") { the_content(); }
			$usepattern = get_post_meta($post->ID, 'usepattern', true);
			if ($usepattern == true) {
			$height = (get_post_meta($post->ID, 'height', true) ? get_post_meta($post->ID, 'height', true) : '300'); ?>
		    <h4>Live Demo</h4>
		<div class="frame-header flex-frame">
		  <div class="btn-group" data-toggle="buttons" id="mobile-toggler">
            <label class="btn btn-default">
              <input type="radio" name="options" id="mobile" autocomplete="off">Mobile
            </label>
            <label class="btn btn-default active">
              <input type="radio" name="options" id="desktop" autocomplete="off" checked>Desktop
            </label>          
          </div>

         <a target="_blank" class="standalone-link" href="<?php echo esc_url( home_url( '/' ));  ?><?php echo $patternPageSlug; ?>?pattern_id=<?php echo $post->ID; ?>">Standalone Demo<i class="sch-external-link"></i></a>
		      </div>	
				<iframe id="pattern-wrap" class="flex-frame" src="<?php echo esc_url( home_url( '/' ));  ?><?php echo $patternPageSlug; ?>?pattern_id=<?php echo $post->ID; ?>" style="width:100%;height:<?php echo $height.'px' ?>" data-preview-height="<?php echo $height; ?>">
			    </iframe>
		    
<?php 
$resources = get_post_meta($post->ID, 'resources', true); 
if(count($resources)>0){
	echo '<div class="resources-wrap"><h4>Requires</h4>';
foreach ($resources as $resource) {
	$resource_obj = get_post($resource);
	if (get_post_status($resource_obj->ID)=='publish'){
    echo '<span class="resource-desc"><a href="'.get_permalink($resource_obj->ID).'">'.$resource_obj->post_title.'</a></span>';
    }
}
	echo '</div>';
}

$key="html";
$string = htmlspecialchars(get_post_meta($post->ID, $key, true), ENT_QUOTES, "UTF-8");
if($string){echo '<h4>Markup</h4><div id="markup"><pre><code>'.$string.'</code></pre></div>';}

$key="css";
$string = htmlspecialchars(get_post_meta($post->ID, $key, true), ENT_QUOTES, "UTF-8");
if($string){echo '<h4>CSS</h4><div id="markup"><pre><code>'.$string.'</code></pre></div>';}

$key="notes";
$string = get_post_meta($post->ID, $key, true);
if($string){echo '<h4>Notes</h4><code>'.$string.'</div>';}

} //end if usepattern
?>		
				</div>
	</div>

<?php endwhile; // end of the loop. ?>