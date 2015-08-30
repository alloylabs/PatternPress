<?php
/*
Template Name: Pattern Preview
*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?php $post = get_post($_GET['pattern_id']); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <meta name="viewport" content="width=device-width">
  <title><?php echo get_bloginfo('name'); ?> - Pattern Preview : <?php echo $post->post_title; ?> - </title>
  <?php 
if (get_post_meta($post->ID, 'resources', true)) {  
        $resources = get_post_meta($post->ID, 'resources', true);
        foreach ($resources as $resource) {
          $resource_obj = get_post($resource);
          if (get_post_status($resource_obj->ID)=='publish'){
              $resource_meta = get_post_meta($resource_obj->ID);
              echo $resource_meta['include'][0];
          }
        }
}
?> 
  <style type="text/css">
  body{padding:20px;}
  @media (max-width: 768px){ 
  body{padding:10px;}  
  }
  <?php 
  if (get_post_meta($post->ID, 'css', true)) {  
          echo get_post_meta($post->ID, 'css', true);
  }
  ?>
  </style>
</head>
<body>
<?php 
if (get_post_meta($post->ID, 'html', true)) {  
        echo str_replace("\r", "",  get_post_meta($post->ID, 'html', true));
}
?>
</body>
</html>