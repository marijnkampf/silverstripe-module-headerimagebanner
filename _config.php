<?php

// Ensure compatibility with PHP 7.2 ("object" is a reserved word),
// with SilverStripe 3.6 (using Object) and SilverStripe 3.7 (using SS_Object)
if (!class_exists('SS_Object')) class_alias('Object', 'SS_Object');

SS_Object::add_extension('Image', 'hibImage');
SS_Object::add_extension('Image', 'hibPageImage');

SS_Object::add_extension('Page', 'HeaderImageBanner');
SS_Object::add_extension('Page_Controller', 'HeaderImageBanner_Controller');

SS_Object::add_extension('SiteConfig', 'HeaderImageBanner');

/** Setting for mysite/_config.php See readme.md **/ 
/*
HeaderImageBanner::$hibMaxImages = 0; 								// Set maximum number of images per page 0 = no limit

HeaderImageBanner::$hibWidth = 600;										// Width of banner image
HeaderImageBanner::$hibHeight = 150;									// Height of banner image

HeaderImageBanner::$hibDefaultToType = array("Parent", "SiteConfig", "Children", "All");	// Order in which to search for images (see readme.md)

HeaderImageBanner::$hibCMSUserEdit = true;						// Allow users to select banner images

HeaderImageBanner::$includeJQuery = true;							// Set to false if jQuery is already included 
HeaderImageBanner::$hibFolder = 'headerimagebanner'; 	// Adjust if module installed in different location

HeaderImageBanner::$hibCMSTabs = array("SiteConfig" => "Root.HeaderImageBanners", "default" => "Root.Content.HeaderImageBanners"); // Tabs to use for page types
HeaderImageBanner::$hibCMSCaption = 'Header Image Banner(s)';		// Caption used in CMS
*/
