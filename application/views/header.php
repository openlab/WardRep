<?php defined('BASEPATH') OR exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
<head> 
	<title>WardRep</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta name="Author" content="Aaron McGowan" />
	<meta name="robots" content="index, follow" />
    
	<link rel="stylesheet" href="<?php print $base_path; ?>/assets/stylesheets/1140.css" type="text/css" media="screen" />
	
	<!--[if lte IE 9]>
	<link rel="stylesheet" href="<?php print $base_path; ?>/assets/stylesheets/ie.css" type="text/css" media="screen" />
	<![endif]-->
	
	<link rel="stylesheet" href="<?php print $base_path; ?>/assets/stylesheets/typeimg.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php print $base_path; ?>/assets/stylesheets/smallerscreen.css" media="only screen and (max-width: 1023px)" />
	<!--// <link rel="stylesheet" href="<?php print $base_path; ?>/assets/stylesheets/mobile.css" media="handheld, only screen and (max-width: 767px)" /> //-->
	<link rel="stylesheet" href="<?php print $base_path; ?>/assets/stylesheets/layout.css" type="text/css" media="screen" />
    
    <link rel="stylesheet" href="<?php print $base_path; ?>/assets/stylesheets/application.css" media="screen" type="text/css" />
    
    <script type="text/javascript" src="<?php print $base_path; ?>/assets/javascript/jquery.min.js"></script>
    <script type="text/javascript">
    <?php if( isset($application_js) ) : ?>
    <?php print $application_js; ?>
    <?php endif; ?>
    </script>
    <script type="text/javascript" src="<?php print $base_path; ?>/assets/javascript/Application.js"></script>
    
    <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-20070932-1']);
    _gaq.push(['_trackPageview']);
  
    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s  = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
    </script>
</head>
<body id="top">
<div class="container wrapper">
    <div class="row header">
        <ul class="navigation">
            <li class="first"><a href="<?php print site_url('/about/'); ?>" title="About">About</a></li>
            <li class="last"><a href="<?php print site_url('/feedback/'); ?>" title="Feedback">Feedback</a></li>
        </ul>
        <h1><a href="<?php print site_url('/'); ?>" title="WardRep">WardRep</a></h1>
    </div>