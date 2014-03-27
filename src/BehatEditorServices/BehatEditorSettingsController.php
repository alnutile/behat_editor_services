<?php namespace BehatEditorServices;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;


class BehatEditorSettingsController extends BaseController
{

    public $behatHelper;
    public $yml;
    public $site;
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
        //2. Get the site
        $sites = $this->siteModel->getSitesForUserId($this->user->uid, FALSE);
        if(!in_array($site_id, $sites['node'])) {
            return array('status' => 'error', 'message' => 'User does not have permission for this site', 'data' => null);
        }
        $site = $sites['node'][$site_id];
        //Now we have the folder that is needed get the the file and return it


    }

}
