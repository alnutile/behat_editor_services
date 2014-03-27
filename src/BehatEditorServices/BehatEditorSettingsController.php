<?php namespace BehatEditorServices;


use BehatEditorServices\BehatServicesException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;


class BehatEditorSettingsController extends BaseController
{

    public $behatHelper;
    public $yml;
    public $site;
    public $path;
    public $site_id;
    public $sites;
    public $siteModel;
    public $fileSystem;
    public $user;

    public function __construct(Filesystem $fileSystem = null, Yaml $yml = null, SitesRepository $siteModel = null, $user = null)
    {
        parent::__construct();
        $this->fileSystem           = ($fileSystem == null) ? new Filesystem : $fileSystem;
        $this->siteModel            = ($siteModel == null) ? new SitesRepository() : $siteModel;
        $this->yml                  = ($yml == null) ? new Yaml() : $yml;
        $this->user                 = ($user == null) ? parent::getUser() : $user;
        //$this->behatHelper  = ($behatHelper == null) ? new BehatServicesHelper() : $behatHelper;
    }


    public function retrieve($request)
    {
        //1. Site ID to look into
        list($site_id) = $request;
        $this->site_id = $site_id;
        //2. Get the site
        $this->getSites();
        try {
            $this->checkAccess($site_id);
        } catch(BehatServicesException $e) {
            return array('status' => 'error', 'message' => $e->getMessage(), 'data' => null);
        }
        $this->getSiteFromSitesArray();
        $path = $this->site['full_path'];

        if($this->fileSystem->exists($path . '/settings.yml')) {
            $file = $this->yml->parse($path . '/settings.yml');
        } else {
            $file = $this->defaultSettings();
        }
        return array('status' => 'success', 'data' => $file, 'message' => "Success getting file");
    }

    public function udpate($request)
    {
        list($site_id, $content) = $request;
        $this->site_id = $site_id;

        $this->getSites();
        try {
            $this->checkAccess($site_id);
        } catch(BehatServicesException $e) {
            return array('status' => 'error', 'message' => "User does not have permission to update the file", 'data' => null);
        }

        if(!is_array($content)) {
            return array('status' => 'error', 'data' => null, 'message' => "Content needs to be an array");
        }

        $this->getSiteFromSitesArray();
        $this->getPathFromSite();
        $updated_file = $this->yml->dump($content);
        $this->fileSystem->dumpFile($this->path . '/settings.yml', $updated_file);
        return array('status' => 'success', 'message' => "File updated", 'data' => $updated_file);
    }

    private function getSiteFromSitesArray()
    {
        $this->site = $this->sites['node'][$this->site_id];
    }

    private function getPathFromSite()
    {
        $this->path = $this->site['full_path'];
    }

    private function getSites()
    {
        $this->sites = $this->siteModel->getSitesForUserId($this->user->uid, TRUE);
    }

    //@TODO this should be in the SiteRepo or SiteModel
    private function checkAccess($site_id)
    {
        if(!isset($this->sites['node'][$site_id])) {
            throw new BehatServicesException('User does not have access to site');
        }
    }

    public function defaultSettings()
    {
        return array(
            'defaults' => [
                'default_tag' => '@example',
                'base_url'    => 'http://google.com'
            ],
            'github' => [
                'github_username' => 'test',
                'github_password' => 'test',
                'test_folder'     => 'tests',
                'github_account'  => 'testuser'
            ],
            'saucelabs' => [
                'browser' => [
                    'username'      => "testuser",
                    'access-key'    => 'accessskey',
                    'browser'       => 'firefox',
                    'os'            => 'Windows 2003',
                    'name'          => "Testing with Saucelabs",
                ],
                'host'          => "ondemand.saucelabs.com",
                'port'          => 80
            ],
        );
    }

}
