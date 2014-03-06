<?php namespace BehatEditorServices;


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
        $this->behatRoutes = new BehatEditorRoutes($this->sitesController, $this->testsController, $this->reportsController, $this->batchesController, $this->tagsController, $this->tokensController);
    }

    /**
     * Sending this no args should get the Sites@index action
     */
    public function testGetSitesAll()
    {
        $this->sitesController->shouldReceive('index')->once()->andReturn('All Sites Mocked');
        $output = $this->behatRoutes->getSites();
        $this->assertNotNull($output);
        $this->assertEquals('All Sites Mocked', $output);
    }

    /**
     * Sending this no args should get the Sites@index action
     */
    public function testGetSite()
    {
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $output = $this->behatRoutes->getSites(array('10'));
        $this->assertEquals('Get Site 10 Mocked', $output);
    }

    /**
     * Send a site test arg so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesTestsAll()
    {
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->testsController->shouldReceive('index')->once()->andReturn('All Tests Mocked');

        $output = $this->behatRoutes->getSitesTests(array(1, 'tests', null, null));
        $this->assertEquals('All Tests Mocked', $output);
    }

    /**
     * Send a site id and test id so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesTestsByID()
    {
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->testsController->shouldReceive('getTest')->once()->andReturn('Get Test 2 or site 1 Mocked');

        $output = $this->behatRoutes->getSitesTests(array(1, 'tests', 2));
        $this->assertEquals('Get Test 2 or site 1 Mocked', $output);
    }

    /**
     * Send a site test arg so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesReportsAll()
    {
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->reportsController->shouldReceive('index')->once()->andReturn('All Reports for Test 2 and Site 1 Mocked');
        $output = $this->behatRoutes->getSitesTestsReports(array(1, 'tests', '2', 'reports', null, null));
        $this->assertEquals('All Reports for Test 2 and Site 1 Mocked', $output);
    }

    /**
     * Send a site test arg so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesReportById()
    {
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->reportsController->shouldReceive('getReport')->once()->andReturn('Report 3 for Test 2 and Site 1 Mocked');

        $output = $this->behatRoutes->getSitesTestsReports(array(1, 'tests', '2', 'reports', '3'));
        $this->assertEquals('Report 3 for Test 2 and Site 1 Mocked', $output);
    }

    public function testGetSitesReportsTagsX()
    {
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->reportsController->shouldReceive('getReport')->once()->andReturn('Report 3 for Test 2 and Site 1 Mocked');
        $output = $this->behatRoutes->getSitesReportsTags(array(1, 'tests', '2', 'reports', '3'));
        $this->assertEquals('Report 3 for Test 2 and Site 1 Mocked', $output);
    }

    public function testGetSitesReportsURLX()
    {
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->reportsController->shouldReceive('getReport')->once()->andReturn('Report 3 for Test 2 and Site 1 Mocked');
        $output = $this->behatRoutes->getSitesReportsUrls(array(1, 'tests', '2', 'reports', '3'));
        $this->assertEquals('Report 3 for Test 2 and Site 1 Mocked', $output);
    }

    public function testGetSitesBatchesAll(){
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->batchesController->shouldReceive('index')->once()->andReturn('All Batches Mocked');
        $output = $this->behatRoutes->getSitesBatches(array(1, 'batches', null, null, null));
        $this->assertEquals('All Batches Mocked', $output);
    }

    public function testGetSitesBatchesXYZ(){
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->batchesController->shouldReceive('getBatch')->once()->andReturn('Batches XYZ Mocked');
        $output = $this->behatRoutes->getSitesBatches(array(1, 'batches', 123, null, null));
        $this->assertEquals('Batches XYZ Mocked', $output);
    }

    public function testGetSitesTokensAll(){
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->tokensController->shouldReceive('index')->once()->andReturn('All Tokens Mocked');
        $output = $this->behatRoutes->getSitesTokens(array(1, 'tags', null, null, null));
        $this->assertEquals('All Tokens Mocked', $output);
    }

    public function testGetSitesTagsAll(){
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->tagsController->shouldReceive('index')->once()->andReturn('All Tags Mocked');
        $output = $this->behatRoutes->getSitesTags(array(1, 'tags', null, null, null));
        $this->assertEquals('All Tags Mocked', $output);
    }

    public function testGetSitesTestsTokensAll()
    {
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->testsController->shouldReceive('getTest')->once()->andReturn('Tests x Mocked');

        $output = $this->behatRoutes->getSitesTestsTokens(array(1, 'tests', 123, 'tokens', null));
        $this->assertEquals('Tests x Mocked', $output);
    }

    public function testGetSitesTestsTokensXYZ()
    {
        $this->sitesController->shouldReceive('getSite')->once()->andReturn('Get Site 10 Mocked');
        $this->testsController->shouldReceive('getTest')->once()->andReturn('Tests x Mocked');

        $output = $this->behatRoutes->getSitesTestsTokens(array(1, 'tests', 123, 'tokens', 123));
        $this->assertEquals('Tests x Mocked', $output);
    }
}