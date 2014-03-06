<?php namespace BehatEditorServices;

class BehatEditorSitesController extends BaseController {

    public function retrieve()
    {
        return array(1,2,3, 'sites');
    }

    public function update()
    {
        return array(1,2,3,'update sites');
    }
}