<?php namespace BehatEditorServices;

use BehatApp\ReportRepository;
use BehatApp\BehatHelper;

class BehatReportRepository extends ReportRepository {

    public $reportModel;
    public $behatHelper;

    public function __construct(SitesRepository $siteModel = null, $user = null, ReportModel $reportModel = null, BehatHelper $behatHelper = null)
    {
        parent::__construct(null);
        $this->siteModel            = ($siteModel == null) ? new SitesRepository() : $siteModel;
        $this->reportModel          = ($reportModel == null) ? new ReportModel() : $reportModel;
        $this->behatHelper          = ($behatHelper == null) ? new BehatHelper() : $behatHelper;
        $this->user                 = ($user == null) ?  static::getUser() : $user;

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

    public function retrieveBySiteId(array $sites_array)
    {
        $reports_all = null;
        $reports_all_output = [];
        $sites = $this->getUsersSites([], FALSE);
        $reports_all = $this->reportModel->retrieveBySiteId($sites_array);
        foreach($reports_all as $report) {
            if(in_array($report->site_id, $sites['node'])) {
                $reports_all_output[] = $report;
            }
        }
        return $reports_all_output;
    }

    public function retrieveBySiteIdAndTestName($site_id, $test_name)
    {
        $reports_all = null;
        $reports_all_output = [];
        $sites = $this->getUsersSites([], FALSE);
        $test_name = $this->behatHelper->replaceDashWithDots($test_name);
        $reports_all = $this->reportModel->retrieveBySiteIdAndTestName($site_id, $test_name);
        foreach($reports_all as $report) {

            if(in_array($report->site_id, $sites['node'])) {
                $reports_all_output[] = $report;
            }
        }
        return $reports_all_output;
    }


    public function create($site_id, $test_name, $request)
    {
        $sites = $this->getUsersSites([], FALSE);
        if(!in_array($site_id, $sites['node'])) {
            return array('data' => null, 'status' => 'error', 'message' => 'You do not have permissions for that site id', 'code' => '403');
        }
        $default_request = $this->dataArray();
        $insert = array_merge($default_request, $request);
        $result = $this->reportModel->persist($insert);
        if($result['error'] == 0 && $result['data'] > 0) {
            return array('data' => $result['data'], 'status' => 'success', 'message' => "Report Inserted", "code" => 201);
        } else {
            return array('data' => null, 'status' => 'error', 'message' => "Could not insert data", "code" => 422);
        }
    }

    public function update($report_id, $request)
    {
        $report = $this->retrieve($request['rid']);
        if($report) {
            $result = $this->reportModel->persist($request);

            //@TODO move the results if statement into it's own method to reuse for this all of this
            if($result['error'] == 0 && $result['data'] > 0) {
                return array('data' => $result['data'], 'status' => 'success', 'message' => "Report Updated", "code" => 201);
            } else {
                return array('data' => null, 'status' => 'error', 'message' => "Could not update data", "code" => 422);
            }
        } else {
            return array('data' => null, 'status' => 'error', 'message' => 'You do not have permissions for that site id', 'code' => '403');
        }
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