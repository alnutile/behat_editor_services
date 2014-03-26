<?php namespace BehatEditorServices;

use BehatEditorServices\BehatReportRepository;
use Mockery;

class BehatReportRepositoryTest extends BaseTests {

    public $repo;

    public function setUp()
    {
        parent::setUp();
        $siteRepo = Mockery::mock('BehatEditorServices\SitesRepository');
        $user = (object) array('uid' => 1);
        $reportModel = Mockery::mock('BehatEditorServices\ReportModel');
        $this->repo = new BehatReportRepository($siteRepo,$user,$reportModel);
    }

    public function testIndex()
    {
        $sites = $this->sites();
        $this->repo->siteModel->shouldReceive('getSitesForUserId')->once()->andReturn([$sites]);
        $this->repo->reportModel->shouldReceive('retrieveBySiteId')->once()->andReturn($this->reports());
        $response = $this->repo->index();
        $this->assertEquals('22', $response[22]->site_id);
        $this->assertNotEmpty($response);
    }

    public function testRetrieveByReportId()
    {
        $this->repo->siteModel->shouldReceive('getSitesForUserId')->once()->andReturn($this->sitesArray());
        $this->repo->reportModel->shouldReceive('retrieve')->once()->andReturn($this->reports());
        $response = $this->repo->retrieve([1]);
        $this->assertEquals('22', $response->site_id);
        $this->assertNotEmpty($response);
    }

    public function testRetrieveByReportIdIfUserNotInSites()
    {
        $this->repo->siteModel->shouldReceive('getSitesForUserId')->once()->andReturn($this->sitesArrayWrongUser());
        $this->repo->reportModel->shouldReceive('retrieve')->once()->andReturn($this->reports());
        $response = $this->repo->retrieve([1]);
        $this->assertEmpty($response);
    }


    public function testRetrieveBySitesId()
    {
        $this->repo->siteModel->shouldReceive('getSitesForUserId')->once()->andReturn($this->sitesArray());
        $reports = $this->reports();
        $this->repo->reportModel->shouldReceive('retrieveBySiteId')->once()->andReturn([$reports]);
        $response = $this->repo->retrieveBySiteId([22]);
        $this->assertEquals('22', $response[0]->site_id);
        $this->assertNotEmpty($response);
    }

    public function testRetrieveBySitesIdButUserNotInGroup()
    {
        $this->repo->siteModel->shouldReceive('getSitesForUserId')->once()->andReturn($this->sitesArrayWrongUser());
        $reports = $this->reports();
        $this->repo->reportModel->shouldReceive('retrieveBySiteId')->once()->andReturn([$reports]);
        $response = $this->repo->retrieveBySiteId([22]);
        $this->assertEmpty($response);
    }

    public function sitesArrayWrongUser()
    {
        return array('node' => array(1,2,4));
    }

    public function sitesArray()
    {
        return array('node' => array(1,22,4));
    }

    public function sites()
    {
        $sites = array(
            'nid' => 22,
        );
        return (object) $sites;
    }

    public function reports()
    {
        $reports = array(
            'site_id' => 22,
            'rid'     => 1,
            'user_id' => 1
        );
        return (object) $reports;
    }


    public function report()
    {
        $reports = array(
            'site_id' => 22,
            'rid'     => 1,
            'user_id' => 1
        );
        return (object) $reports;
    }
}