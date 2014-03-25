<?php namespace BehatEditorServices;

use BehatEditorServices\FeatureModel;
use BehatEditorServices\SiteModel;
use BehatEditorServices\BehatServicesHelper;
use BehatApp\BehatTestsController;
use BehatWrapper\BehatWrapper;
use BehatWrapper\BehatCommand;
use BehatEditorServices\BaseController;

class BehatEditorTestsController extends BaseController {

    protected $model;
    protected $siteModel;
    protected $behatServiceHelper;
    protected $behatTestsRunner;
    public    $behatWrapper;

    public function __construct(FeatureModel $model = null, SiteModel $siteModel = null, BehatServicesHelper $behatServiceHelper = null, BehatTestsController $behatTestsRunner = null, BehatWrapper $behatWrapper = null) {
        parent::__construct();
        $this->siteModel            = ($siteModel == null) ? new SiteModel() : $siteModel;
        $this->model                = ($model == null) ? new FeatureModel() : $model;
        $this->behatServiceHelper   = ($behatServiceHelper == null) ? new BehatServicesHelper() : $behatServiceHelper;
        $this->behatTestsRunner     = ($behatTestsRunner == null) ? new BehatTestsController() : $behatTestsRunner;
        $this->behatWrapper         = ($behatWrapper == null) ? new BehatWrapper() : $behatWrapper ;
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
        $site = $params[5]['site'];
        $test = $params[5]['test'];
        $results = $this->model->create($test, $site);
        return $results;
    }

    public function update($params, $request){
        $site = $params[5]['site'];
        $test = $params[5]['test'];
        $results = $this->model->update($test, $site);
        return $results;
    }

    public function delete($params, $request){}

    public function index(array $params = null){
        //1 we have the site nid here so lets use that to get all the tests
        $site = $this->siteModel->getSitesUUIDFromNid($params[0]);
        return $site;
    }

    /**
     * Need a moment to get the paths for the site and test
     *
     * @param $params
     * @return array
     */
    public function run($params)
    {
        $output = array();
        $site_id    = $params[0];
        $test_name  = $params[2];
        $test_name  = $this->behatServiceHelper->behelper->replaceDashWithDots($test_name);
        $site       = $this->siteModel->getSitesUUIDFromNid($site_id);
        $config     = $site->full_path;
        if(!isset($site->testFiles[$test_name])) {
            return array('errors' => 1, 'message' => "Test does not exists in this site", 'data' => (array) $site);
        }
        $test_path  = $site->testFiles[$test_name]['path'];
        $this->behatServiceHelper->behelper->setBasePath($config . '/');
        $yml_path   = $this->behatServiceHelper->behelper->getBehatYmlPath();

        $this->behatWrapper->setBehatBinary($this->getVendorPath());
        $command = BehatCommand::getInstance()
            ->setOption('config', $yml_path)
            ->setFlag('no-paths')
            ->setTestPath($test_path);
        $output = $this->behatWrapper->run($command);

        return array('data' => $output, 'errors' => 0, 'message' => "You are here");
    }

    public function getVendorPath()
    {
        $path = variable_get('composer_manager_vendor_dir');
        $path = $path . '/bin';
        return drupal_realpath($path);
    }
}