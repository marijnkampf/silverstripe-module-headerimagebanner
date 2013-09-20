# Header Image Banner Module for SilverStripe

## Maintainers

 * Marijn Kampf (Nickname: marijnkampf)
	<marijn at exadium dot com>

	Alpha version

	Sponsored by Exadium Web Development http://www.exadium.com

## Introduction

Easily include header image banners in templates of your SilverStripe website. If no banner image(s) are defined you can set whether the use images from parents, children or site config. If multiple images are used they are displayed using Nivo slider.

## Requirements

* SilverStripe 3.0
* Nivo-slider (included) 
* Requires jQuery version 1.5 (included)

## Instalation and setup

* Install in folder headerimagebanner in root of your silverstripe
* run /dev/build on your website
* In your template include: `<% include HeaderImageBanner %>`
 
## Options 
Options can be set in mysite/_config.php
 
* `HeaderImageBanner::$hibMaxImages = 0;`
	Set maximum number of images per page 0 = no limit

* `HeaderImageBanner::$hibWidth = 600;`
	Set width of your banner image
* `HeaderImageBanner::$hibHeight = 150;`
	Set height of your banner image

* `HeaderImageBanner::$hibDefaultToType = array("Parent", "SiteConfig", "Children");`
	Order in which to search for images
	Parent: uses banner images from parent page, if parent doesn't have any it look at the parent of the parent, etc.
	SiteConfig: uses banner images defined in SiteConfig
	Children: uses banner images in Children and the Children's children, etc.

Please note the all functionality available in SS 2.4 is no longer available.
	All: Uses all images that are defined as hibImage in the database.
	(TODO Folder: Use images from specific folder)

* `HeaderImageBanner::$hibCMSUserEdit = true;`
	Set to false if you don't want users to be able to select banner images

* `HeaderImageBanner::$includeJQuery = true;`
	Set to false if you already include jQuery and doesn't need to be included again.
* `HeaderImageBanner::$hibFolder = 'headerimagebanner';`
	Set to folder name if module installed in different

* `HeaderImageBanner::$hibCMSTabs = array("SiteConfig" => "Root.HeaderImageBanners", "default" => "Root.Content.HeaderImageBanners");`
	Tabs to use for page types
* `HeaderImageBanner::$hibCMSCaption = 'Header Image Banner(s)';`
	Field caption used in CMS
