<?php
class HeaderImageBanner extends DataObjectDecorator {
	/*
HeaderImageBanner


Settings:
	Single Banner
	Multiple Banners
		Random
		Slider

		Max banner images		
		Folder (that has selected image)
	
	When no banner specified
		Parent banner / Child banner
		Folder
		Fixed default
		
	Changed by user (yes/no)
	
	
Usage
_config.php

Template:
	<% include HeaderImageBanner %>
	*/
	
	/**
	 * Random headerImage cache to ensure multiple calls
	 * from page return same headerImage
	 */
	private static $hibCachedImages = false;
	public static $hibFolder = 'headerimagebanner';

	public static $hibMaxImages = 0; // 0 = no limit
	public static $hibUseFolder = false;
	
	public static $includeJQuery = true;
	
	public static $hibWidth = 600;
	public static $hibHeight = 150;
	
	public static $hibCMSCaption = 'Header Image Banner(s)';
	
	public static $hibDefaultToType = array("Parent", "SiteConfig", "Children", "All");

	public static $hibCMSTabs = array("SiteConfig" => "Root.HeaderImageBanners", "default" => "Root.Content.HeaderImageBanners");

	public static $hibCMSUserEdit = true;
	
	function extraStatics() {
		return array(
      'many_many' => array(
         'hibImages' => 'hibImage'
      )
    );
  }
  
  public function hibGetWidth() {
  	return HeaderImageBanner::$hibWidth;
  }
  
  public function hibGetHeight() {
  	return HeaderImageBanner::$hibHeight;
  }
  
  public function hibGetCMSCaption() {
  	return HeaderImageBanner::$hibCMSCaption . " (" . HeaderImageBanner::$hibWidth . " x " . HeaderImageBanner::$hibHeight . " px)";
  }
  
  public function hibRandom() {
  	return Rnd();
  }

	public function updateCMSFields(&$fields) {
		//$fields->addFieldToTab(HeaderImageBanner::$hibCMSTab, new DropDownField('hibHeaderImagesType', 'If no header image, select from', $this->dbObject('hibHeaderImagesType')->enumValues()));
		if (HeaderImageBanner::$hibCMSUserEdit) {
			if (isset(HeaderImageBanner::$hibCMSTabs[$this->owner->ClassName])) $tabs = HeaderImageBanner::$hibCMSTabs[$this->owner->ClassName];
			else if (isset(HeaderImageBanner::$hibCMSTabs["default"])) $tabs = HeaderImageBanner::$hibCMSTabs["default"];
			else $tabs = "Root.Content.HeaderImageBanners";
	  	$fields->addFieldToTab($tabs, $fup = new MultipleFileUploadField('hibImages', HeaderImageBanner::hibGetCMSCaption()));
	  }
	}

	function hibImagesFromChildren() {
		$hibImages = new DataObjectSet();
		if ($this->owner->hasMethod("Children")) {
			if ($this->owner->Children()) foreach($this->owner->Children() as $child) {
				$tempImages = $child->showHibImages(0, false);
				if (isset($tempImages) && ($tempImages->Count() > 0)) $hibImages->merge($tempImages);
				$tempImages = $child->hibImagesFromChildren();
				if (isset($tempImages) && ($tempImages->Count() > 0)) $hibImages->merge($tempImages);
			}
		}
		return $hibImages;
	}
	
	function getAllHibImages() {
		//return DataObject::get("hibImage", "", "RAND()");
		return DataObject::get("hibImage");
		
	}
	
	function startSlider() {
//			Debug::Show("start?");
//		if ($this->hibCachedImages->Count() > 1) {
//			Debug::Show("start");
			Requirements::javascript(HeaderImageBanner::$hibFolder . "/javascript/startslider.js");
//		}
	}
	
	function showSlider() {
		return ($this->hibCachedImages->Count() > 1);
	}
	
	function singleHibImage() {
		return ($this->hibCachedImages->Count() == 1);		
	}
	
	function showHibImages($maxCount = false, $recursive = true) {
		if ($maxCount == false) $maxCount = HeaderImageBanner::$hibMaxImages;
		if ((isset($this->hibCachedImages)) && ($this->hibCachedImages)) {
			while($this->hibCachedImages->Count() > $maxCount) $this->hibCachedImages->pop();
			return $this->hibCachedImages;
		}

		$images = $this->owner->hibImages();
		if (($recursive) && ($images->Count() == 0) && (is_array(HeaderImageBanner::$hibDefaultToType))) foreach(HeaderImageBanner::$hibDefaultToType as $action) {
			if (!isset($images) || (count($images) == 0)) {
				switch($action) {
					case 'All':
						$images = $this->getAllHibImages($maxCount, false);
					break;
					case 'Parent':
						if (($this->owner->hasMethod("Parent")) && ($this->owner->Parent()->hasMethod("showHibImages"))) {
							$images = $this->owner->Parent()->showHibImages(0, true);
						}
					break;
					case 'SiteConfig':
						$config = SiteConfig::current_site_config(); 
						if ($config->hasMethod("showHibImages")) {
							$images = $config->showHibImages(0, false);
						}
					break;
					case 'Children':
						$images = $this->hibImagesFromChildren();
						if (isset($images)) $images->removeDuplicates("ID");
					break;
				}
			}
		}

		$this->hibCachedImages = new DataObjectSet();

		// Copy randomized
		if (isset($images->items)) {
			$keys = array_keys($images->items);
			while((($this->hibCachedImages->Count() < $maxCount) || ($maxCount == 0)) && (count($keys) > 0)) {
				$rndKey = array_rand($keys);
				if (isset($images->items[$rndKey])) $this->hibCachedImages->push($images->items[$rndKey]);
				unset($keys[$rndKey]);
			}
		}
		return $this->hibCachedImages;
	}
}


class HeaderImageBanner_Controller extends DataObjectDecorator {
	function onAfterInit() {
		Requirements::css(HeaderImageBanner::$hibFolder . "/templates/css/headerimagebanner.css", "screen");
		Requirements::css(HeaderImageBanner::$hibFolder . "/thridparty/nivo-slider/themes/default/default.css", "screen");
		Requirements::css(HeaderImageBanner::$hibFolder . "/thridparty/nivo-slider/nivo-slider.css", "screen");

		if (HeaderImageBanner::$includeJQuery) Requirements::javascript(HeaderImageBanner::$hibFolder . "/thridparty/jquery-1.7.1.min.js");
		Requirements::javascript(HeaderImageBanner::$hibFolder . "/thridparty/nivo-slider/jquery.nivo.slider.pack.js");
	}
}