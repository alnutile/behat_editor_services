<?php namespace BehatEditorServices;


use BehatEditorServices\BehatServicesException;
use BehatEditorServices\SitesRepository;
use BehatEditorServices\SiteModel;

class FeatureModel extends BaseModel
{
    public $siteModel;
    public $destination;

    public function __construct()
    {
        parent::__construct();
        //$this->siteModel =  ($siteModel == null) ? new SiteModel() : $siteModel;
    }

    public function getTestsInPath($full_path)
    {
            $render_files = [];
            $files = $this->helper->behatFeatureModel->getAll(array($full_path . '/features/'));
            foreach($files as $file) {
                $name = $file->getFilename();
                $render_files[$name]['name']             = $file->getFilename();
                $render_files[$name]['path']             = $file->getRealpath();
                $render_files[$name]['content']          = $file->getContents();
            }
            return $render_files;
    }

    public function retrieve($site_obejct, $test_name )
    {
        $test_name = $this->helper->behelper->replaceDashWithDots($test_name);
        if($site_obejct->testFiles) {
            return $site_obejct->testFiles[$test_name];
        }
        return false;
    }

    public function create($params, $site_object)
    {
        //1. use params[0] to get the test info include the path
        $this->destination = $site_object->full_path;
        var_dump($this->destination);
        //1 take the content in the request to make the file
    }
}