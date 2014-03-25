<?php namespace BehatEditorServices;

use Mockery;
use BehatEditorServices\SiteModel;

function drupal_realpath() {
    $date = time();
    return "/tmp/tests/$date";
}

class SitesModelTest extends BaseTests {

    public $repo;
    public $siteModel;

    public function setUp()
    {
        parent::setup();
        $this->repo = Mockery::mock('BehatEditorServices\SitesRepository');
        $this->siteModel = new SiteModel($this->repo);
    }

    public function tearDown()
    {
        $this->fileSystem->remove("/tmp/tests");
    }

    public function testgetSitesForUserId()
    {
        $this->repo->shouldReceive('getSitesForUserId')->once()->andReturn(array(1,2,3));
        $output = $this->siteModel->getSitesForUserId(123);
        $this->assertEquals(array(1,2,3), $output);
    }

    public function testgetSitesAndTestsForSiteUUID()
    {
        $this->repo->shouldReceive('getSiteAndTestsForSiteUUID')->once()->andReturn(array(1,2,3));
        $output = $this->siteModel->getSiteAndTestsForSiteUUID(123);
        $this->assertEquals(array(1,2,3), $output);
    }
}