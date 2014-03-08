<?php namespace BehatEditorServices;

use BehatEditorServices\BehatServicesHelper;

class BaseModel {
    public $helper;

    public function __construct(BehatServicesHelper $helper = null)
    {
        //We need to setup the helper with the needed paths
        $this->helper       = ($helper == null) ? new BehatServicesHelper() : $helper;
    }

}