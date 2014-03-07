<?php namespace BehatEditorServices;

/**
 * This is just to verify the Router has the correct methods in place
 * This will not test much else. Since the router is not responsible for validations etc
 * it is just passing of the work to the controller in charge and the action/method in use
 *
 * Class BehatEditorServicesTest
 * @package BehatEditorServices
 */
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
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $output = $this->behatRoutes->getSites(array('10'));
        $this->assertEquals('Get Site 10 Mocked', $output);
    }

    /**
     * Send a site test arg so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesTestsAll()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
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
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->testsController->shouldReceive('retrieve')->once()->andReturn('Get Test 2 or site 1 Mocked');

        $output = $this->behatRoutes->getSitesTests(array(1, 'tests', 2));
        $this->assertEquals('Get Test 2 or site 1 Mocked', $output);
    }

    /**
     * Send a site test arg so we get sites/tests
     * eg all tests for that site
     */
    public function testGetSitesReportsAll()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
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
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->reportsController->shouldReceive('retrieve')->once()->andReturn('Report 3 for Test 2 and Site 1 Mocked');

        $output = $this->behatRoutes->getSitesTestsReports(array(1, 'tests', '2', 'reports', '3'));
        $this->assertEquals('Report 3 for Test 2 and Site 1 Mocked', $output);
    }

    public function testGetSitesReportsTagsX()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->reportsController->shouldReceive('retrieve')->once()->andReturn('Report 3 for Test 2 and Site 1 Mocked');
        $output = $this->behatRoutes->getSitesReportsTags(array(1, 'tests', '2', 'reports', '3'));
        $this->assertEquals('Report 3 for Test 2 and Site 1 Mocked', $output);
    }

    public function testGetSitesReportsURLX()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->reportsController->shouldReceive('retrieve')->once()->andReturn('Report 3 for Test 2 and Site 1 Mocked');
        $output = $this->behatRoutes->getSitesReportsUrls(array(1, 'tests', '2', 'reports', '3'));
        $this->assertEquals('Report 3 for Test 2 and Site 1 Mocked', $output);
    }

    public function testGetSitesBatchesAll(){
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->batchesController->shouldReceive('index')->once()->andReturn('All Batches Mocked');
        $output = $this->behatRoutes->getSitesBatches(array(1, 'batches', null, null, null));
        $this->assertEquals('All Batches Mocked', $output);
    }

    public function testGetSitesBatchesXYZ(){
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->batchesController->shouldReceive('retrieve')->once()->andReturn('Batches XYZ Mocked');
        $output = $this->behatRoutes->getSitesBatches(array(1, 'batches', 123, null, null));
        $this->assertEquals('Batches XYZ Mocked', $output);
    }

    public function testGetSitesTokensAll(){
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->tokensController->shouldReceive('index')->once()->andReturn('All Tokens Mocked');
        $output = $this->behatRoutes->getSitesTokens(array(1, 'tags', null, null, null));
        $this->assertEquals('All Tokens Mocked', $output);
    }

    public function testGetSitesTagsAll(){
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->tagsController->shouldReceive('index')->once()->andReturn('All Tags Mocked');
        $output = $this->behatRoutes->getSitesTags(array(1, 'tags', null, null, null));
        $this->assertEquals('All Tags Mocked', $output);
    }

    public function testGetSitesTestsTokensAll()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->testsController->shouldReceive('retrieve')->once()->andReturn('Tests x Mocked');

        $output = $this->behatRoutes->getSitesTestsTokens(array(1, 'tests', 123, 'tokens', null));
        $this->assertEquals('Tests x Mocked', $output);
    }

    public function testGetSitesTestsTokensXYZ()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->testsController->shouldReceive('retrieve')->once()->andReturn('Tests x Mocked');

        $output = $this->behatRoutes->getSitesTestsTokens(array(1, 'tests', 123, 'tokens', 123));
        $this->assertEquals('Tests x Mocked', $output);
    }

    public function testpostSitesTests()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->testsController->shouldReceive('create')->once()->andReturn('Post Test 2 or site 1 Mocked');

        $output = $this->behatRoutes->postSitesTests(array(1, 'tests', 2));
        $this->assertEquals('Post Test 2 or site 1 Mocked', $output);
    }

    public function testpostSitesTestReports()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->reportsController->shouldReceive('create')->once()->andReturn('Post Reports 2 or site 1 Mocked');

        $output = $this->behatRoutes->postSitesTestsReports(array(1, 'reports', 2));
        $this->assertEquals('Post Reports 2 or site 1 Mocked', $output);
    }

    public function testpostSitesBatches()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->batchesController->shouldReceive('create')->once()->andReturn('Post Batches 2 or site 1 Mocked');

        $output = $this->behatRoutes->postSitesBatches(array(1, 'batches', 2));
        $this->assertEquals('Post Batches 2 or site 1 Mocked', $output);
    }

    public function testpostSitesTestsTokens()
    {
        $this->sitesController->shouldReceive('retrieve')->once()->andReturn('Get Site 10 Mocked');
        $this->tokensController->shouldReceive('create')->once()->andReturn('Post Tokens 2 or site 1 Mocked');

        $output = $this->behatRoutes->postSitesTestsTokens(array(1, 'reports', 2));
        $this->assertEquals('Post Tokens 2 or site 1 Mocked', $output);
    }

    public function testputSites()
    {
        $this->sitesController->shouldReceive('update')->once()->andReturn('Updated');
        $output = $this->behatRoutes->putSites(array(1, null, null, null, null), array('default token'));
        $this->assertEquals('Updated', $output);
    }

    public function testputSitesTests()
    {
        $this->testsController->shouldReceive('update')->once()->andReturn('Updated');
        $output = $this->behatRoutes->putSitesTests(array(1, null, null, null, null), array('default token'));
        $this->assertEquals('Updated', $output);
    }

    public function testputSitesTestsReports()
    {
        $this->reportsController->shouldReceive('update')->once()->andReturn('Updated');
        $output = $this->behatRoutes->putSitesTestsReports(array(1, null, null, null, null), array('default token'));
        $this->assertEquals('Updated', $output);
    }

    public function testputSitesBatches()
    {
        $this->batchesController->shouldReceive('update')->once()->andReturn('Updated');
        $output = $this->behatRoutes->putSitesBatches(array(1, null, null, null, null), array('default token'));
        $this->assertEquals('Updated', $output);
    }

    public function testputSitesTestsTokens()
    {
        $this->tokensController->shouldReceive('update')->once()->andReturn('Updated');
        $output = $this->behatRoutes->putSitesTestsTokens(array(1, null, null, null, null), array('default token'));
        $this->assertEquals('Updated', $output);
    }

}