<?php namespace BehatEditorServices;

use BehatEditorServices\SitesModel;

class BehatEditorSitesController extends BaseController {
    protected $model;

    public function __construct(SiteModel $model = null) {
        parent::__construct();
        $this->model        = ($model == null) ? new SiteModel() : $model;

    }
    public function retrieve($request)
    {
        return array(1,2,3, 'sites');
    }

    public function update($params, $request)
    {
        return array(1,2,3,'update sites');
    }

    public function index(array $params = null)
    {
        $sites = $this->model->getSitesForUserId($params);
        return $sites;
    }

    /**
     * This will take the site info especially the node
     * uuid that DMP offers and make a folder for it in the
     * private folder area of drupal.
     *
     * @param $site_uuid
     * @param $params
     *
     * return TRUE if all is well FALSE if not.
     */
    public function create($site_uuid, $params)
    {
        $output = $this->model->create($site_uuid, $params);
        return $output;
    }
}