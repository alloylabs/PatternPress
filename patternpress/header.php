<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
  <title><?php wp_title(''); ?></title>

  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.2.1.4.min.js"></script>
  <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/bootstrap.js"></script>  

  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/styles.css" type="text/css" rel="stylesheet">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/bootstrap_theme.css" type="text/css" rel="stylesheet">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/typography.css" type="text/css" rel="stylesheet">
  <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/font-awesome.min.css" type="text/css" rel="stylesheet">


  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/js/highlight/styles/vs.css"/>
  <script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/highlight/highlight.pack.js"></script>
  <script>
    //Demo Code Highligher   
      hljs.configure({tabReplace: '  '}); // 2 spaces
      hljs.initHighlightingOnLoad();
    //End Demo Code Highligher   
    
//mobileToggler
$( document ).on( 'click', '#mobile-toggler', function() {
        if($('#mobile').prop("checked")){
            $('.flex-frame').animate({width:"320px"}, 500 );
            $('#pattern-wrap').animate({height:'568px'}, 500 );
        } else {
            $('.flex-frame').animate({width:"100%"}, 500 );
            $('#pattern-wrap').animate({height:$('#pattern-wrap').attr('data-preview-height')+'px'}, 500 );
        }
    }); 
  </script>

</head>

<body <?php body_class(); ?>>
<header role="banner" class="group" id="header">
	<div class="container">
    <div class="row">
    <div class="col-xs-12">
    <a href="<?php bloginfo('siteurl'); ?>/" id="logo">
			 <?php echo get_bloginfo('name'); ?>
		</a>
    <div class="search-form">
      <?php get_search_form( true ); ?>
    </div>
	</div>
  </div>
    </div>
</header>
<div class="container" id="main-content">
    <div id="sidebar" class="sidebar">
    <?php get_sidebar(); ?>
  </div>