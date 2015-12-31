<?php

class hibImage extends DataExtension
{
    public static $belongs_many_many = array(
        'HeaderImageBanners' => 'HeaderImageBanner'
    );
    
    public function hibCroppedImage()
    {
        return $this->owner->croppedImage(HeaderImageBanner::$hibWidth, HeaderImageBanner::$hibHeight);
    }
    
    public function random()
    {
        return rand();
    }
}


class hibPageImage extends DataExtension
{
    public static $belongs_many_many = array(
        'HeaderImageBanners' => 'Page'
    );
}
