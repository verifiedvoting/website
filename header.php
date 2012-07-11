<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- load fonts -->
<link href='http://fonts.googleapis.com/css?family=Vollkorn:400italic,400' rel='stylesheet' type='text/css'>

<!-- styles -->
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/styles.css" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<!-- javascript -->
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/bootstrap/js/bootstrap.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/search_bar.js"></script>

<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?> data-spy="scroll" data-target=".subnav" data-offset="50">
  <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="row">
            <div class="span3">
              &nbsp;
              <a class="brand" href="/">
                <i id="logo" class="icon-ok icon-white"></i>Verified Voting
              </a>
            </div>
            <div class="span9">
                <div class="nav-section a-items right group">
                    <form id="search-form" 
                          class="pull-right form-search full-only" 
                          action="/search" 
                          method="get" >
                      <input name="q" placeholder="Search" id="navbar-search" class="input-small search-query" type="text">
                      <button id="navbar-search-btn" class="btn" type="submit">Go</button>
                    </form>
                    
                   
                    <div id="action-items" class="pull-right full-only">
                      <div class="btn-group">
                        <a class="btn" href="#">Donate</a>
                        <a class="btn" href="#">Take Action</a>
                      </div>
                    </div>
                </div>
                <!-- nav-section -->
                
                <div class="nav-collapse">
                  <div class="nav-wrapper nav-section left">
                    <ul class="nav">
                  <li class="">
                    <a href="/search">Search</a>
                  </li>
                  <li class="">
                    <a href="/news">News</a>
                  </li>
                  <li class="">
                    <a href="/verifier">Verifier</a>
                  </li>
                  <li class="">
                    <a href="/blog">Blog</a>
                  </li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown"
                        href="#">
                        About
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="">
                        <a href="/base-css.html">Our Mission</a>
                      </li>
                      <li class="">
                        <a href="/base-css.html">Staff</a>
                      </li>
                      <li class="">
                        <a href="/base-css.html">Board</a>
                      </li>
                      <li class="">
                        <a href="base-css.html">Contact Us</a>
                      </li>
                    </ul>
                  </li>
                  <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown"
                        href="#">
                        Press/Media
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="">
                        <a href="#">Press Contacts</a>
                      </li>
                      <li class="">
                        <a href="#">Press Releases</a>
                      </li>
                      <li class="">
                        <a href="#">In the News</a>
                      </li>
                      <li class="">
                        <a href="#">Contact Us</a>
                      </li>
                    </ul>
                  </li>
                </ul>
                  </div><!--/nav wrapper-->
                
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="main" class="container">