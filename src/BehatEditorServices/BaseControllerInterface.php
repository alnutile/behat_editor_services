<?php namespace BehatEditorServices;

interface BaseControllerInterface {

    public function retrieve();
    public function create();
    public function update();
    public function delete();
    public function index();

}