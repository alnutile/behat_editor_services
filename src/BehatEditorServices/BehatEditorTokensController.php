<?php namespace BehatEditorServices;

class BehatEditorTokensController extends BaseController {

    public function create($params, $request)
    {
        return [1,2,3,'tokens'];
    }

    public function update($args, $params)
    {
        return array(1,2,3,'update tokens');
    }
}