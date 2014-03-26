<?php namespace BehatEditorServices;



class BehatEditorReportsController extends BaseController {

    public $siteModel;

    public function __construct(BehatReportRepository $reportRepo = null, $user = null)
    {
        parent::__construct();
        $this->reportRepo           = ($reportRepo == null) ? new BehatReportRepository() : $reportRepo;
        $this->user                 = ($user == null) ?  static::getUser() : $user;
    }

    public function create($args, $params)
    {
        return array(1,2,3,4, 'reports');
    }

    public function update($args, $params)
    {
        return array(1,2,3,'update report');
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
}