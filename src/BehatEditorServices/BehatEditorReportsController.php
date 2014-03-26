<?php namespace BehatEditorServices;


class BehatEditorReportsController extends BaseController {

    public $siteModel;

    public function __construct(BehatReportRepository $reportRepo = null, $user = null)
    {
        parent::__construct();
        $this->reportRepo           = ($reportRepo == null) ? new BehatReportRepository() : $reportRepo;
        $this->user                 = ($user == null) ?  static::getUser() : $user;
    }

    public function create($params, $request)
    {
        list($site_id, $test_name) = $params;
        return $this->reportRepo->create($site_id, $test_name, $request);
    }

    public function update($args, $params)
    {
        return $this->reportRepo->update($args[4], $args[5]);
    }

    public function index(array $params = null)
    {
        return $this->reportRepo->index();
    }

    public function retrieve($request)
    {
        return $this->reportRepo->retrieve($request);
    }

    public function retrieveBySiteId($request)
    {
        if(empty($request[2])) {
            return $this->reportRepo->retrieveBySiteId(array($request[0]));
        } else {
            return $this->reportRepo->retrieve($request[2]);
        }
    }

    public function retrieveBySiteIdAndTestName($site_id, $test_name, $report_id = false)
    {
        if($report_id == NULL || $report_id == false) {
            return $this->reportRepo->retrieveBySiteIdAndTestName($site_id, $test_name);
        } else {
            return $this->reportRepo->retrieve($report_id);
        }
    }

}