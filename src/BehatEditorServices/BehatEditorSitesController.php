<?php namespace BehatEditorServices;

class BehatEditorSitesController extends BaseController {

    public function retrieve($request)
    {
        return array(1,2,3, 'sites');
    }

    public function update($params, $request)
    {
        return array(1,2,3,'update sites');
    }
}