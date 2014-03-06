<?php namespace BehatEditorServices;

use BehatEditorServices\BehatEditorSitesController;
use BehatEditorServices\BehatEditorReportsController;
use BehatEditorServices\BehatEditorTestsController;
use BehatEditorServices\BehatEditorTokensController;
use BehatEditorServices\BehatEditorTagsController;
use BehatEditorServices\BehatEditorBatchesController;

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
        $this->sitesController          = ($sitesController   == null)  ? new BehatEditorSitesController()   : $sitesController;
        $this->testsController          = ($testsController   == null)  ? new BehatEditorTestsController()   : $testsController;
        $this->reportsController        = ($reportsController == null)  ? new BehatEditorReportsController() : $reportsController;
        $this->batchesController        = ($batchesController == null)  ? new BehatEditorBatchesController() : $batchesController;
        $this->tagsController           = ($tagsController    == null)  ? new BehatEditorTagsController()    : $tagsController;
        $this->tokensController         = ($tokensController  == null)  ? new BehatEditorTokensController()  : $tokensController;
    }

    /** GET REQUESTS */
    public function getSites(array $params = null)
    {
        if($params[0] == null) {
            return $this->sitesController->index();
        } else {
            return $this->sitesController->retrieve($params[0]);
        }
    }

    public function getSitesTests(array $params = null)
    {
        $site_object = $this->getSites(array($params[0]));

        if($params[2] == null) {
            return $this->testsController->index($params, $site_object);
        } else {
            return $this->testsController->retrieve($params, $site_object);
        }
    }

    public function getSitesReports(array $params = null)
    {
        $site_object = $this->getSites(array($params[0]));

        if($params[4] == null) {
            return $this->reportsController->index($params, $site_object);
        } else {
            return $this->reportsController->retrieve($params, $site_object);
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
            return $this->batchesController->index($params, $site_object);
        } else {
            return $this->batchesController->retrieve($params, $site_object);
        }
    }

    public function getSitesTags(array $params = null) {
        $site_object = $this->getSites(array($params[0]));
        return $this->tagsController->index($params, $site_object);
    }

    public function getSitesTokens(array $params = null) {
        $site_object = $this->getSites(array($params[0]));
        return $this->tokensController->index($params, $site_object);
    }

    /** POST REQUESTS */
    public function postSitesTests(array $params = null, array $request = null) {
         $site_object = $this->getSites(array($params[0]));
         return $this->testsController->create($params, $request, $site_object);
    }

    public function postSitesTestsReports(array $params = null, array $request = null) {
        $site_object = $this->getSites(array($params[0]));
        return $this->reportsController->create($params, $request, $site_object);
    }

    public function postSitesBatches(array $params = null, array $request = null) {
        $site_object = $this->getSites(array($params[0]));
        return $this->batchesController->create($params, $request, $site_object);
    }

    public function postSitesTestsTokens(array $params = null, array $request = null) {
        $site_object = $this->getSites(array($params[0]));
        return $this->tokensController->create($params, $request, $site_object);
    }

    /** PUT REQUESTS */
    public function putSites(array $params = null, array $request = null)
    {
        return $this->sitesController->update($params, $request);
    }

    public function putSitesTests(array $params = null, array $request = null)
    {
        return $this->testsController->update($params, $request);
    }

    public function putSitesTestsReports(array $params = null, array $request = null)
    {
        return $this->reportsController->update($params, $request);
    }

    /** DELETE REQUESTS */


    /** helpers */

    public function setSiteId($id)
    {
        $this->siteId           = $id;
        return $this;
    }
}