<?php namespace BehatEditorServices;

interface BaseControllerInterface {

    public function retrieve($params);
    public function create($params, $request);
    public function update($params, $request);
    public function delete($params, $request);
    public function index($params);

}