<?php

Object::add_extension('Page', 'HeaderImageBanner');
Object::add_extension('Page_Controller', 'HeaderImageBanner_Controller');

Object::add_extension('SiteConfig', 'HeaderImageBanner');

/** Setting for mysite/_config.php **/ See readme.md
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