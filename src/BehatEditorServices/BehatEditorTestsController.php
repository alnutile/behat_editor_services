<?php namespace BehatEditorServices;

use BehatEditorServices\FeatureModel;
use BehatEditorServices\SiteModel;

class BehatEditorTestsController extends BaseController {

    protected $model;
    protected $siteModel;

    public function __construct(FeatureModel $model = null, SiteModel $siteModel = null) {
        parent::__construct();
        $this->siteModel        = ($siteModel == null) ? new SiteModel() : $siteModel;
        $this->model            = ($model == null) ? new FeatureModel() : $model;
    }

    public function retrieve($params = null){
        //Now we have the site nid and the test name
        //I could get the site and then pluck the item in the tests array?
        //or I can just make the path and get the data
        $site_object = $this->siteModel->getSitesUUIDFromNid($params[0]);
        $test = $this->model->retrieve($site_object, $params[2]);
        return $test;
    }

    public function create($params, $request){

        //1. Pass request to FeatureModel
        //
        $site_object = $this->siteModel->getSitesUUIDFromNid($params[0]);
        $results = $this->model->create($params, $site_object);
        return [1,2,3];
    }

    public function update($params, $request){
        return [1,2,3, 'update tests'];
    }

    public function delete($params, $request){}

    public function index(array $params = null){
        //1 we have the site nid here so lets use that to get all the tests
        $site = $this->siteModel->getSitesUUIDFromNid($params[0]);
        return $site;
    }
}