<?php namespace BehatEditorServices;

/**
 * By using this between my other classes I can
 * then more easily mock the results as needed
 *
 * Class ServicesRepository
 * @package BehatEditorServices
 */
class ServicesRepository {


    public $helpers;

    public function __construct()
    {

    }

    public function preProcessOutput($params)
    {
        list($data) = $params;
        return $data;
    }

    public function buildNodeArray($result, $model)
    {
        $sites = array();
        if (isset($result['node']) && is_object($model)) {
            $sites = array_keys($result['node']);
            $sites = entity_load('node', $sites);
            $sites->full_path = $model->getFullPath();
        }
        return $sites;
    }



}