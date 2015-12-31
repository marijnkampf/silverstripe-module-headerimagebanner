<?php
class HeaderImageBanner extends DataExtension
{
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
    private $hibCachedImages = false;
    public static $hibFolder = 'headerimagebanner';

    public static $hibMaxImages = 0; // 0 = no limit
    public static $hibUseFolder = false;
    
    public static $includeJQuery = true;
    
    public static $hibWidth = 600;
    public static $hibHeight = 150;
    
    public static $hibCMSCaption = 'Header Image Banner(s)';
    
    public static $hibDefaultToType = array("Parent", "SiteConfig", "Children", "All");

    public static $hibCMSTabs = array("SiteConfig" => "Root.HeaderImageBanners", "default" => "Root.HeaderImageBanners");

    public static $hibCMSUserEdit = true;
    
    public static $many_many = array(
    'hibImages' => 'Image'
  );
  
    public function hibGetWidth()
    {
        //return $this->config()->hibWidth;
    return HeaderImageBanner::$hibWidth;
    }
  
    public function hibGetHeight()
    {
        //return $this->config()->hibHeight;
    return HeaderImageBanner::$hibHeight;
    }
  
    public function hibGetCMSCaption()
    {
        return HeaderImageBanner::$hibCMSCaption . " (" . HeaderImageBanner::$hibWidth . " x " . HeaderImageBanner::$hibHeight . " px)";
    }
  
    public function hibRandom()
    {
        return Rnd();
    }

    public function updateCMSFields(FieldList $fields)
    {
        //$fields->addFieldToTab(HeaderImageBanner::$hibCMSTab, new DropDownField('hibHeaderImagesType', 'If no header image, select from', $this->dbObject('hibHeaderImagesType')->enumValues()));
        if (HeaderImageBanner::$hibCMSUserEdit) {
            if (isset(HeaderImageBanner::$hibCMSTabs[$this->owner->ClassName])) {
                $tabs = HeaderImageBanner::$hibCMSTabs[$this->owner->ClassName];
            } elseif (isset(HeaderImageBanner::$hibCMSTabs["default"])) {
                $tabs = HeaderImageBanner::$hibCMSTabs["default"];
            } else {
                $tabs = "Root.HeaderImageBanners";
            }

            $upload = new UploadField('hibImages', HeaderImageBanner::hibGetCMSCaption());
            $upload->setConfig('allowedMaxFileNumber', 25);
            $upload->getValidator()->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
            $fields->addFieldToTab($tabs, $upload);

//	  	$fields->addFieldToTab($tabs, $upload = new UploadField('hibImages', HeaderImageBanner::hibGetCMSCaption()));
//			$uf->setConfig('allowedMaxFileNumber', 10);
        }
    }

    public function hibImagesFromChildren()
    {
        $hibImages = new ArrayList();
        if ($this->owner->hasMethod("Children")) {
            if ($this->owner->Children()) {
                foreach ($this->owner->Children() as $child) {
                    $tempImages = $child->showHibImages(0, false);
                    if (isset($tempImages) && ($tempImages->Count() > 0)) {
                        $hibImages->merge($tempImages);
                    }
                    $tempImages = $child->hibImagesFromChildren();
                    if (isset($tempImages) && ($tempImages->Count() > 0)) {
                        $hibImages->merge($tempImages);
                    }
                }
            }
        }
        return $hibImages;
    }
    
    public function startSlider()
    {
        Requirements::javascript(HeaderImageBanner::$hibFolder . "/javascript/startslider.js");
    }
    
    public function showSlider()
    {
        return ($this->hibCachedImages->Count() > 1);
    }
    
    public function singleHibImage()
    {
        return ($this->hibCachedImages->Count() == 1);
    }
    
    public function showHibImages($maxCount = false, $recursive = true)
    {
        if ($maxCount == false) {
            $maxCount = HeaderImageBanner::$hibMaxImages;
        }
        if ((isset($this->hibCachedImages)) && ($this->hibCachedImages)) {
            while ($this->hibCachedImages->Count() > $maxCount) {
                $this->hibCachedImages->pop();
            }
            return $this->hibCachedImages;
        }

        $images = new ArrayList($this->owner->hibImages()->toArray());

        if (($recursive) && ($images->Count() == 0) && (is_array(HeaderImageBanner::$hibDefaultToType))) {
            foreach (HeaderImageBanner::$hibDefaultToType as $action) {
                if (!isset($images) || (count($images) == 0)) {
                    switch ($action) {
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
                        if (isset($images)) {
                            $images->removeDuplicates("ID");
                        }
                    break;
                }
                }
            }
        }

        $this->hibCachedImages = new ArrayList();

        if ($images->Count() > 0) {
            $keys = $images->column("ID");
            while ((($this->hibCachedImages->Count() < $maxCount) || ($maxCount == 0)) && (count($keys) > 0)) {
                $rndKey = array_rand($keys);
                $this->hibCachedImages->push($images[$rndKey]);
                unset($keys[$rndKey]);
            }
        }
        return $this->hibCachedImages;
    }
}


class HeaderImageBanner_Controller extends DataExtension
{
    public function onAfterInit()
    {
        Requirements::css(HeaderImageBanner::$hibFolder . "/templates/css/headerimagebanner.css", "screen");
        Requirements::css(HeaderImageBanner::$hibFolder . "/thridparty/nivo-slider/themes/default/default.css", "screen");
        Requirements::css(HeaderImageBanner::$hibFolder . "/thridparty/nivo-slider/nivo-slider.css", "screen");

        if (HeaderImageBanner::$includeJQuery) {
            Requirements::javascript(HeaderImageBanner::$hibFolder . "/thridparty/jquery-1.7.1.min.js");
        }
        Requirements::javascript(HeaderImageBanner::$hibFolder . "/thridparty/nivo-slider/jquery.nivo.slider.pack.js");
    }
}
