<?php namespace BehatEditorServices;


use BehatEditorServices\BehatServicesException;
use BehatEditorServices\SitesRepository;
use BehatEditorServices\SiteModel;
use BehatApp\BehatFormatter;
use BehatApp\BehatFeatureModel;

class FeatureModel extends BaseModel
{
    public $siteModel;
    public $destination;
    public $behatFormatter;
    public $behatFeatureModule;

    public function __construct(BehatFormatter $behatFormatter = null, BehatFeatureModel $behatFeatureModule = null)
    {
        parent::__construct();
        $this->behatFormatter = ($behatFormatter == null) ? new BehatFormatter() : $behatFormatter;
        $this->behatFeatureModule = ($behatFeatureModule == null) ? new BehatFeatureModel() : $behatFeatureModule;
        //$this->siteModel =  ($siteModel == null) ? new SiteModel() : $siteModel;
    }

    public function getTestsInPath($full_path)
    {
            $render_files = [];
            $files = $this->helper->behatFeatureModel->getAll(array($full_path . '/features/'));
            foreach($files as $file) {
                $name = $file->getFilename();
                $render_files[$name]['name']                 = $file->getFilename();
                $render_files[$name]['path']                 = $file->getRealpath();
                $render_files[$name]['content']              = $file->getContents();
                $render_files[$name]['content_html']         = $this->behatFormatter->plainToHtml($file->getContents());
                $render_files[$name]['name_dashed']          = $this->helper->behelper->replaceDotsWithDashes($file->getFilename());
            }
            return $render_files;
    }

    public function retrieve($site_object, $test_name )
    {
        $test_name = $this->helper->behelper->replaceDashWithDots($test_name);
        if($site_object->testFiles) {
            return $site_object->testFiles[$test_name];
        }
        return false;
    }

    public function update($params, $site_object)
    {
        $content        = $params['content'];
        $destination    = $params['path'];
        $results = $this->behatFeatureModule->update([$content, $destination]);
        return array('message' => $results['message'], 'data' => $results['data'], 'errors' => $results['error']);
    }

    public function create($params, $site_object)
    {
        //1. use params[0] to get the test info include the path
        $this->destination = $site_object->full_path;
        var_dump($this->destination);
        //1 take the content in the request to make the file
    }
}