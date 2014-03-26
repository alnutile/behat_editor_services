<?php namespace BehatEditorServices;

class BaseController implements BaseControllerInterface  {

    public function __construct()
    {

    }

    static public function getUser()
    {
        global $user;
        return $user;
    }

    public function retrieve($request){}
    public function create($params, $request){}
    public function update($params, $request){}
    public function delete($params, $request){}
    public function index(array $params = null){}
}