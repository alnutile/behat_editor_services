<?php namespace BehatEditorServices;


use BehatEditorServices\BehatServicesException;
use BehatEditorServices\SitesRepository;

class SiteModel extends BaseModel
{

    public $site_id;
    public $repo;

    public function __construct(SitesRepository $repo = null)
    {
        //We need to setup the helper with the needed paths
        $this->repo       = ($repo == null) ? new SitesRepository() : $repo;
    }

    public function create($site_id, $site_object)
    {
        $output = $this->setSiteId($site_id)
            ->setupFolder();
        return $output;
    }

    public function setSiteId($id)
    {
        $this->site_id = $id;
        return $this;
    }

    public function getSiteId()
    {
        return $this->site_id;
    }

    public function setupFolder()
    {
        if($this->getSiteId() == null) {
            throw new BehatServicesException("You need to setSiteId");
        }
        $this->helper->setSiteFolderInBasePathUsingSiteId($this->getSiteId());
        $this_sites_path = $this->helper->getSitesFolderInBasePath();
        $this->helper->behelper->fileSystem->mkdir($this_sites_path);
        //2 copy over template stuff into the folder
        $this->helper->behelper
            ->setTemplateFolder($this->helper->getVendorRoot() . '/alnutile/behat_editor_core/lib/BehatApp/template_files/')
            ->setBasePath($this_sites_path)
            ->copyTemplateFilesOver($this_sites_path);
        return $this->helper->getSitesFolderInBasePath();
    }

    public function getSitesForUserId($user_id = null)
    {
        $output = $this->repo->getSitesForUserId($user_id);
        return $output;
    }
}