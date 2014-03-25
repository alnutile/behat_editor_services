<?php namespace BehatEditorServices;

use BehatEditorServices\SiteModel;

class BehatEditorSitesController extends BaseController {
    protected $model;

    public function __construct(SiteModel $model = null, $user = null) {
        parent::__construct();
        $this->model        = ($model == null) ? new SiteModel() : $model;
        $this->user         = ($user == null) ?  static::getUser() : $user;

    }

    static private function getUser()
    {
        global $user;
        return $user;
    }

    public function retrieve($params)
    {
        $site = $this->model->getSitesUUIDFromNid($params[0]);
        return $site;
    }

    public function update($params, $request)
    {
        return array(1,2,3,'update sites');
    }

    public function index(array $params = null)
    {
        if(!isset($params[0])){
            $user_id = $this->user->uid;
        }
        $sites = $this->model->getSitesForUserId($user_id);
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