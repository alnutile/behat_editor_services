<?php namespace BehatEditorServices;

use BehatApp\ReportRepository;

class BehatReportRepository extends ReportRepository {

    public $reportModel;

    public function __construct(SitesRepository $siteModel = null, $user = null, ReportModel $reportModel = null)
    {
        parent::__construct(null);
        $this->siteModel            = ($siteModel == null) ? new SitesRepository() : $siteModel;
        $this->reportModel          = ($reportModel == null) ? new ReportModel() : $reportModel;
        $this->user                 = ($user == null) ?  static::getUser() : $user;

    }

    public function findAllBySiteId(array $sites_array)
    {

        foreach($sites_array as $value)
        {
            //for each site id we need to find the rows.
            // could be a simple in query too on the db?
        }
    }

    public function index()
    {
        $reports_all = [];
        $sites = $this->getUsersSites([]);

        foreach($sites as $site) {
            $reports_all[$site->nid] = $this->reportModel->retrieveBySiteId($site->nid);
        }
        return $reports_all;
    }

    //@TODO move this filter to it's own class
    //  call it user member of site or owner type filter
    public function retrieve($report_id)
    {
        $reports_all = null;
        $sites = $this->getUsersSites([], FALSE);
        $reports_all = $this->reportModel->retrieve($report_id);
        if(in_array($reports_all->site_id, $sites['node'])) {
            return $reports_all;
        }
        return [];
    }

    private function getUsersSites($params, $load_nodes = TRUE)
    {
        $sites = [];
        if(!isset($params[0])){
            $sites = $this->siteModel->getSitesForUserId($this->user->uid, $load_nodes);
            return $sites;
        } else {
            $sites = $this->siteModel->getSitesUUIDFromNid($params[0]);
            return $sites;
        }
        return $sites;
    }

    static public function getUser()
    {
        global $user;
        return $user;
    }

}