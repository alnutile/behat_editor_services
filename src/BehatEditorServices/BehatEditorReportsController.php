<?php namespace BehatEditorServices;

class BehatEditorReportsController extends BaseController {

    public function create($args, $params)
    {
        return array(1,2,3,4, 'reports');
    }

    public function update($args, $params)
    {
        return array(1,2,3,'update report');
    }
}