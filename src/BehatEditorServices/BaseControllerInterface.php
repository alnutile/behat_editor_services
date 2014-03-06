<?php namespace BehatEditorServices;

interface BaseControllerInterface {

    public function retrieve();
    public function create($args, $params);
    public function update($args, $params);
    public function delete();
    public function index();

}