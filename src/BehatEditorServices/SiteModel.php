<?php namespace BehatEditorServices;

use BehatEditorServices\BehatServicesException;

class SiteModel extends BaseModel
{

    public $site_id;

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
        //URLs?
        //Tokens
        //root folder
        return $this->helper->getSitesFolderInBasePath();
    }

}