<?php namespace BehatEditorServices;

use BehatEditorServices\BehatEditorReportsController;
use Mockery;

class BehatEditorReportsControllerTest extends BaseTests {

    public $reportCtrl;

    public function setUp()
    {
        parent::setUp();

        $siteModel = Mockery::mock('BehatEditorServices\SiteModel');
        $user = (object) ['uid' => 1];
        $siteModel->shouldReceive('getSitesForUserId')->once()->andReturn(array(1,2,3));
        $this->reportCtrl = new BehatEditorReportsController($siteModel, $user);
    }

    public function testIndex()
    {
        $output = $this->reportCtrl->index();
        $this->assertNotEmpty($output);
    }
}