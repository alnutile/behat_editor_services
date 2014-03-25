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
        $content        = $params['content'];
        $destination    = $params['path'];
        //Just need to add some info to the test file
        // so I can return a new model
        $results = $this->behatFeatureModule->create([$content, $destination]);
        if ($results['error'] === 0) {
            $params['name_dashed']  =  $this->helper->behelper->replaceDotsWithDashes($params['name']);
            $params['content_html']  =  $this->behatFormatter->plainToHtml($params['content']);
        }
        return array('message' => $results['message'], 'data' => $params, 'errors' => $results['error']);
    }
}