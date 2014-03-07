<?php namespace BehatEditorServices;

use BehatApp\BehatHelper;
use BehatEditorServices\BehatServicesException;

/**
 * This will centralize some key functions I need for the
 * different Classes.
 * Also it will instantiate most of the BehatApp classes
 * so I can centralize any changes here
 *
 * Class BehatServiceHelper
 * @package BehatEditorServices
 */
class BehatServicesHelper {

    public $behelper;
    public $base_path_of_sites;
    public $base_path_of_site;

    public function __construct(BehatHelper $behelper = null)
    {
        $this->behelper = ($behelper == null) ? new BehatHelper() : $behelper;
    }

    /**
     * Using the drupal private:// path to set the
     * base path for all sites in private://behat
     *
     * @params $path string
     *   *full path* to the root folder of all your Site's
     *   tests
     *   eg /var/www/private/behat
     *   would store say /var/www/private/behat/123/tests
     *
     * return BehatEditorServices\BehatServicesHelper
     */
    public function setBasePathOfAllSites($path = null)
    {
        if($path == null) {
            $path = $this->setPathifNull();
        }
        if(!$this->behelper->fileSystem->exists($path)) {
            $this->behelper->createPath($path);
        }
        $this->base_path_of_sites = $path;
        return $this;
    }

    public function getBasePathOfAllSites()
    {
        if($this->base_path_of_sites == null) {
            $this->setBasePathOfAllSites();
        }
        return $this->base_path_of_sites;
    }

    public function setSiteFolderInBasePathUsingSiteId($site_id)
    {
        if(!$this->behelper->fileSystem->exists($this->getBasePathOfAllSites() . '/' . $site_id))
        {
            $this->behelper->createPath($this->getBasePathOfAllSites() . '/' . $site_id);
        }
        $this->base_path_of_site = $this->getBasePathOfAllSites() . $site_id;
        return $this;
    }

    public function getSitesFolderInBasePath()
    {

        return $this->base_path_of_site;
    }

    public function getVendorRoot()
    {
        $vendor = drupal_realpath(variable_get('composer_manager_vendor_dir'));
        return $vendor;
    }

    protected function setPathIfNull()
    {
        $private    = variable_get('file_private_path');
        $public     = variable_get('file_public_path');
        if($public == null || empty($public)) {
            $link = l('admin file', 'admin/config/media/file-system');
            throw new BehatServicesException("There is no public folder setup for this site please configure one $link");
        }
        if($private == null || empty($private)) {
            $public     = drupal_realpath($public);
            $this->behelper->fileSystem->mkdir($public . '/private');
            variable_set('file_private_path', $public . '/private');
        }
        $path = drupal_realpath(variable_get('file_private_path')) . '/behat/';
        return $path;
    }

}