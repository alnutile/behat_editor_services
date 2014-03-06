<?php namespace BehatEditorServices;

use BehatEditorServices\BehatEditorSitesController;
use BehatEditorServices\BehatEditorReportsController;
use BehatEditorServices\BehatEditorTestsController;

class BehatEditorRoutes {

    protected $siteId;
    protected $sitesController;
    protected $testsController;
    protected $reportsController;
    protected $batchesController;
    protected $tagsController;
    protected $tokensController;

    public function __construct($sitesController = null, $testsController = null, $reportsController = null, $batchesController = null, $tagsController = null, $tokensController = null)
    {
        $this->sitesController          = ($sitesController   == null) ? new BehatEditorSitesController()   : $sitesController;
        $this->testsController          = ($testsController   == null) ? new BehatEditorTestsController()   : $testsController;
        $this->reportsController        = ($reportsController == null) ? new BehatEditorReportsController() : $reportsController;
        $this->batchesController        = ($batchesController == null) ? new BehatEditorReportsController() : $batchesController;
        $this->tagsController           = ($tagsController    == null) ? new BehatEditorTagsController()    : $tagsController;
        $this->tokensController         = ($tokensController == null)  ? new BehatEditorTokensController()  : $tokensController;
    }

    public function getSites(array $params = null)
    {
        if($params[0] == null) {
            return $this->sitesController->index();
        } else {
            return $this->sitesController->getSite($params[0]);
        }
    }

    /**
     * GET
     * Tests All for site x
     * Tests x for site x
     *
     * @param array $params
     * @return string
     */
    public function getSitesTests(array $params = null)
    {
        $site_object = $this->getSites(array($params[0]));

        if($params[2] == null) {
            return $this->testsController->index($site_object, $params);
        } else {
            return $this->testsController->getTest($site_object, $params);
        }
    }

    /**
     * GET
     * Reports All for site x and test y
     * Reports All for site x
     * Report x for site x
     * Report x for site x test y
     * Report x for site x test y
     *
     * @param array $params
     * @return string
     */
    public function getSitesReports(array $params = null)
    {
        $site_object = $this->getSites(array($params[0]));

        if($params[4] == null) {
            return $this->reportsController->index($site_object, $params);
        } else {
            return $this->reportsController->getReport($site_object, $params);
        }
    }

    public function getSitesTestsReports(array $params = null)
    {
        return $this->getSitesReports($params);
    }

    public function getSitesTestsTokens(array $params = null)
    {
        return $this->getSitesTests($params);
    }

    public function getSitesReportsTags(array $params = null)
    {
        return $this->getSitesReports($params);
    }

    public function getSitesReportsUrls(array $params = null)
    {
        return $this->getSitesReports($params);
    }

    public function getSitesBatches(array $params = null) {
        $site_object = $this->getSites(array($params[0]));

        if($params[2] == null) {
            return $this->batchesController->index($site_object, $params);
        } else {
            return $this->batchesController->getBatch($site_object, $params);
        }
    }

    public function getSitesTags(array $params = null) {
        $site_object = $this->getSites(array($params[0]));
        return $this->tagsController->index($site_object, $params);
    }

    public function getSitesTokens(array $params = null) {
        $site_object = $this->getSites(array($params[0]));
        return $this->tokensController->index($site_object, $params);
    }


    public function setSiteId($id)
    {
        $this->siteId           = $id;
        return $this;
    }
}