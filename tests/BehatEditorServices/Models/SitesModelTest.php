<?php namespace BehatEditorServices;

use Mockery;
use BehatEditorServices\SitesModel;

class SitesModelTest extends \PHPUnit_Framework_TestCase {

    public $repo;
    public $siteModel;

    public function setUp()
    {
        $this->repo = Mockery::mock('BehatEditorServices\SitesRepository');
        $this->siteModel = new SiteModel($this->repo);
    }

    public function testgetSitesForUserId()
    {
        $this->repo->shouldReceive('getSitesForUserId')->once()->andReturn(array(1,2,3));
        $output = $this->siteModel->getSitesForUserId(123);
        $this->assertEquals(array(1,2,3), $output);
    }
}