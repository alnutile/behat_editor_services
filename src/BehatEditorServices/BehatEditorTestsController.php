<?php namespace BehatEditorServices;

class BehatEditorTestsController extends BaseController {

    public function retrieve($params = null){
        return ["site {$params[0]}", "test {$params[2]}", 'retrieve'];
    }

    public function create($args, $params){
        return [1,2,3];
    }

    public function update($args, $params){
        return [1,2,3, 'update tests'];
    }

    public function delete($params, $request){}

    public function index($params = null){
        return ["site {$params[0]}", 'index tests'];
    }
}