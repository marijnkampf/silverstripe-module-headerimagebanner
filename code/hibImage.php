<?php

class hibImage extends DataExtension {
	static $belongs_many_many = array (
		'HeaderImageBanners' => 'HeaderImageBanner'
	);
	
	function hibCroppedImage() {
		return $this->owner->croppedImage(HeaderImageBanner::$hibWidth, HeaderImageBanner::$hibHeight);
	}
	
	function random() {
		return rand();
	}

}


class hibPageImage extends DataExtension {
	static $belongs_many_many = array (
		'HeaderImageBanners' => 'Page'
	);
 
}