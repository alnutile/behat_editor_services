<?php namespace BehatEditorServices;


class BehatEditorSitesController {

    public function index()
    {
        return "All Sites";
    }

    public function getSite($arg)
    {
        return "Get Site $arg";
    }
}

class BehatEditorTestsController {

    public function index()
    {
        return "All Tests";
    }

    public function getTest()
    {
        return "Get Test 2 or site 1";
    }
}

class BehatEditorReportsController {

    public function index()
    {
        return "All Reports for Test 2 and Site 1";
    }

    public function getReport()
    {
        return "Report 3 for Test 2 and Site 1";
    }
}

class BehatEditorServicesTest extends BaseTests {

    public $behatRoutes;

    public function setUp()
    {
        parent::setUp();
        $sitesController        = new BehatEditorSitesController();
        $testsController        = new BehatEditorTestsController();
        $reportsController      = new BehatEditorReportsController();
        $this->behatRoutes      = new BehatEditorRoutes($sitesController, $testsController, $reportsController);
    }

    /**
     * Sending this no args should get the Sites@index action
     */
    public function testGetSitesAll()
    {
        $output = $this->behatRoutes->getSites();
        $this->assertEquals('All Sites', $output);
    }

    /**
     * Sending this no args should get the Sites@index action
     */
    public function testGetSite()
    {
        $output = $this->behatRoutes->getSites('10');
        $this->assertEquals('Get Site 10', $output);
    }

    /**
     * Send a site test arg so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesTestsAll()
    {
        $output = $this->behatRoutes->getSitesTests(array(1, 'tests'));
        $this->assertEquals('All Tests', $output);
    }

    /**
     * Send a site id and test id so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesTestsByID()
    {
        $output = $this->behatRoutes->getSitesTests(array(1, 'tests', 2));
        $this->assertEquals('Get Test 2 or site 1', $output);
    }

    /**
     * Send a site test arg so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesReportsAll()
    {
        $output = $this->behatRoutes->getSitesTestsReports(array(1, 'tests', '2', 'reports'));
        $this->assertEquals('All Reports for Test 2 and Site 1', $output);
    }

    /**
     * Send a site test arg so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesReportById()
    {
        $output = $this->behatRoutes->getSitesTestsReports(array(1, 'tests', '2', 'reports', '3'));
        $this->assertEquals('Report 3 for Test 2 and Site 1', $output);
    }

    public function testGetSitesBatchesAll(){}
    public function testGetSitesTokensAll(){}
    public function testGetSitesTagsAll(){}

}