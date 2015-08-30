<?php
//create new post type for resources
add_action( 'init', 'create_resource_type' );
function create_resource_type() {
  register_post_type( 'resource',
    array(
      'labels' => array(
            'name'               => _x( 'Resources', 'post type general name', 'patternpress' ),
            'singular_name'      => _x( 'Resource', 'post type singular name', 'patternpress' ),
            'menu_name'          => _x( 'Resources', 'admin menu', 'patternpress' ),
            'name_admin_bar'     => _x( 'Resource', 'add new on admin bar', 'patternpress' ),
            'add_new'            => _x( 'Add New', 'resource', 'patternpress' ),
            'add_new_item'       => __( 'Add New Resource', 'patternpress' ),
            'new_item'           => __( 'New Resource', 'patternpress' ),
            'edit_item'          => __( 'Edit Resource', 'patternpress' ),
            'view_item'          => __( 'View Resource', 'patternpress' ),
            'all_items'          => __( 'All Resources', 'patternpress' ),
            'search_items'       => __( 'Search Resources', 'patternpress' ),
            'parent_item_colon'  => __( 'Parent Resources:', 'patternpress' ),
            'not_found'          => __( 'No resources found.', 'patternpress' ),
            'not_found_in_trash' => __( 'No resources found in Trash.', 'patternpress' )
      ),
      'public' => true,
      'has_archive' => true,
      'menu_postion' => 10,
      'hierarchical' => false,
      'show_in_nav_menus' => true,
      'supports' => array(
        'title',
        'editor'
      )
	 )
   );
}


// Add custom meta boxes
add_action( 'add_meta_boxes', 'patterns_add_meta_box' );

function patterns_add_meta_box() {
    add_meta_box( 
        'patterns',
        'Pattern Options',
        'patterns_meta_box',
        'page',
        'normal',
        'high'
    );

}
function patterns_meta_box( $post ) {
  	wp_nonce_field( plugin_basename( __FILE__ ), 'patterns_noncename' );

  	$html = get_post_meta($post->ID,'html',true);
  	$css = get_post_meta($post->ID,'css',true);
  	$resources = get_post_meta($post->ID,'resources',true);
  	$notes = get_post_meta($post->ID,'notes',true);
  	$height = get_post_meta($post->ID,'height',true);
  	$usepattern = get_post_meta($post->ID,'usepattern',true);


  echo '<label for="'.$post->post_name.'"><input type="checkbox" name="usepattern" id="usepattern" value="true"'.($usepattern ?' checked="true"' : '').'>Show Pattern Options</input></label><br/>';
	
    	echo '<label class="pattern-label" for="resources">Resources</label>';
  	echo '<div class="form-wrap">
  	      <fieldset>';

$args = array( 'post_type' => 'resource', 'published'=> true, 'meta_key' => 'priority', 'orderby' => 'meta_value_num' , 'order' => 'ASC' );

$myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post ); 
	 echo '<label for="'.$post->post_name.'"><input type="checkbox" name="resources[]" id="'.$post->post_name.'" value="'.$post->ID.'"'.($resources && in_array($post->ID, $resources) ? ' checked="true"' : '').'>'.$post->post_title.'</input></label>';	
 endforeach; 
wp_reset_postdata();

  	echo '</fieldset>
  	      </div>';
  
  
	echo '<label class="pattern-label" for="html">Preview Height (px)</label>';
  	echo '<input type="number" id="height" name="height" style="width:120px;float:left;clear:both;" value="' . ($height ? $height : "300") . '"/>';

	echo '<label class="pattern-label" for="html">HTML</label>';
  	echo '<textarea id="html" name="html" rows="10" cols="90" style="width:100%">' . $html . '</textarea>';



	echo '<label class="pattern-label" for="css">CSS</label>';
  echo '<textarea id="css" name="css" rows="10" cols="90" style="width:100%">' . $css . '</textarea>';

    echo '<div class="form-wrap"><label class="pattern-label">Notes</label>	';
  	wp_editor( $notes, 'notes');
  	echo "</div>";
}


add_action('admin_menu', function() {
	remove_meta_box('pageparentdiv', 'pattern', 'normal');
});
add_action('add_meta_boxes', function() {
	add_meta_box('pattern-parent', 'Parent', 'pattern_parent_meta_box', 'pattern', 'side', 'high');
});
 
function pattern_parent_meta_box($post) {
	$post_type_object = get_post_type_object($post->post_type);
	if ( $post_type_object->hierarchical ) {
		$pages = wp_dropdown_pages(array('post_type' => 'page', 'selected' => $post->post_parent, 'name' => 'parent_id', 'show_option_none' => __('(no parent)'), 'sort_column'=> 'menu_order, post_title', 'echo' => 0, 'exclude' => array('17')));
		if ( ! empty($pages) ) {
			echo $pages;
		} // end empty pages check
	} // end hierarchical check.
}

add_action('admin_head', 'admin_css');

function admin_css() {
  echo '<link href="'.get_stylesheet_directory_uri().'/css/wp-admin.css" type="text/css" rel="stylesheet">';
}


//Save updates
add_action( 'save_post', 'patterns_save_post' );
function patterns_save_post( $post_id ) {

	// Ignore if doing an autosave
  	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
  	    return;
			
	// verify data came from pears meta box
  	if ( !wp_verify_nonce( $_POST['patterns_noncename'], plugin_basename( __FILE__ ) ) )
		return;			
	
  	// Check user permissions
  	if ( 'page' == $_POST['post_type'] ) {
    	if ( !current_user_can( 'edit_page', $post_id ) )
        	return;
  	}
  	else{
    	if ( !current_user_can( 'edit_post', $post_id ) )
	        return;
  	}
  	
	if(get_post_type($post_id)=="page"){
		foreach($_POST['resources'] as $check) {
	       $resourceArray[] = $check;  
	    }
	    update_post_meta($post_id, 'resources', $resourceArray);

	  	$html_data = $_POST['html'];
		update_post_meta($post_id, 'html', $html_data);

		$usepattern_data = $_POST['usepattern'];
		update_post_meta($post_id, 'usepattern', $usepattern_data);
		
		$css_data = $_POST['css'];
		update_post_meta($post_id, 'css', $css_data);

	    $notes_data = $_POST['notes'];
		update_post_meta($post_id, 'notes', $notes_data);

		$resources_data = $_POST['resources'];
		update_post_meta($post_id, 'resources', $resources_data);

		$height_data = $_POST['height'];
		update_post_meta($post_id, 'height', $height_data);
	}

	if(get_post_type($post_id)=="resource"){
		$include_data = $_POST['include'];
		update_post_meta($post_id, 'include', $include_data);

		$priority_data = $_POST['priority'];
		update_post_meta($post_id, 'priority', $priority_data);
    }
}



//** RESOURCE PAGES **//
add_action( 'add_meta_boxes', 'resources_add_meta_box' );

function resources_add_meta_box() {

    add_meta_box( 
        'resources',
        'Resource Details',
        'resources_meta_box',
        'resource',
        'normal',
        'high'
    );

}

function resources_meta_box( $post ) {
  	wp_nonce_field( plugin_basename( __FILE__ ), 'patterns_noncename' );

  	$include = get_post_meta($post->ID,'include',true);
  	$priority = get_post_meta($post->ID,'priority',true);

	echo '<label class="pattern-label" for="include">Inclusion Markup</label>';
  echo '<textarea id="include" name="include" rows="4" cols="90" style="width:100%">'.$include.'</textarea>';
	echo '<label class="pattern-label" for="priority" style="margin-right:20px;">Priority</label>';
	echo '<input id="priority" type="number" name="priority" style="width:80px;" value="'.$priority.'"/>';
   
}


function remove_menus(){
  
  //remove_menu_page( 'index.php' );                  //Dashboard
  remove_menu_page( 'edit.php' );                   //Posts
  remove_menu_page( 'upload.php' );                 //Media
  //remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
  //remove_menu_page( 'themes.php' );                 //Appearance
  remove_menu_page( 'plugins.php' );                //Plugins
  //remove_menu_page( 'users.php' );                  //Users
  remove_menu_page( 'tools.php' );                  //Tools
//  remove_menu_page( 'options-general.php' );        //Settings
  remove_menu_page( 'profile.php' );                //Profile
  //remove_menu_page( 'edit.php?post_type=pattern' );                //Patterns
  remove_submenu_page( 'index.php', 'index.php' );
  remove_submenu_page( 'index.php', 'my-sites.php' );
  
}
//if (!current_user_can(manage_options)){
//add_action( 'admin_menu', 'remove_menus' );
//}




// remove unwanted dashboard widgets for relevant users
function patternpress_remove_dashboard_widgets() {
    $user = wp_get_current_user();
    if ( $user->has_cap( 'manage_options' ) ) {
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    }
}
add_action( 'wp_dashboard_setup', 'patternpress_remove_dashboard_widgets' );

function patternpress_add_editor_styles() {
    add_editor_style(  get_bloginfo( stylesheet_directory).'/css/bootstrap.css' );
}
add_action( 'admin_init', 'patternpress_add_editor_styles' );


//create a new page to show pattern previews on theme activation 
add_action('after_switch_theme', 'patternpress_create_pattern_preview');
function patternpress_create_pattern_preview(){
        // Create homepage
        $preveiwer = array(
            'post_type'    => 'page',
            'post_title'    => 'Pattern Preview',
            'post_name'  => 'pattern-preview',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1
        ); 
        // Insert the post into the database
        $preveiwer_id =  wp_insert_post( $preveiwer );
        //set the page template 
        update_post_meta($preveiwer_id, '_wp_page_template', 'pattern-loader.php');
        //save the slug (in case it's a duplicate title) to wp options table
        update_option('pattern_page',$preveiwer_id);
}
//remove pattern_preview page when theme is deactivated
add_action('switch_theme', 'patternpress_delete_pattern_preview');
function patternpress_delete_pattern_preview(){
$postid = get_option('pattern_page');
wp_delete_post( $postid, true );
}

//hide pattern_preview page from admin users so it doesn't get deleted
add_filter( 'parse_query', 'exclude_pages_from_admin' );
function exclude_pages_from_admin($query) {
$postid = get_option('pattern_page');
    global $pagenow,$post_type;
    if (is_admin() && $pagenow=='edit.php' && $post_type =='page') {
        $query->query_vars['post__not_in'] = array($postid);
    }
}