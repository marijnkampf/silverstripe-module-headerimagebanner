<?php

class hibImage extends Image {
/*
 function extraStatics() {
			return array(
					'belongs_many_many' => array(
							'HeaderImageBanners' => 'HeaderImageBanner',
					),
			);
	} 	
*/
	static $belongs_many_many = array (
		'HeaderImageBanners' => 'HeaderImageBanner'
	);
	
	function hibCroppedImage() {
	//Debug::Show($this->owner);
//		$image = DataObject::get_by_id('File', $this->owner->ID);		
//Debug::Show($image);		
		return $this->CroppedImage(HeaderImageBanner::$hibWidth, HeaderImageBanner::$hibHeight);
	}
	
	function random() {
		Debug::Show(rand());
		return rand();
	}

}


class hibPageImage extends Image {
	static $belongs_many_many = array (
		'HeaderImageBanners' => 'Page'
	);
 
}