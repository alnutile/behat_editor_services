<?php namespace BehatEditorServices;

use Mockery;



class BehatEditorSitesControllerTest extends BaseTests {

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Should show all sites for the user
     */
    public function testIndex()
    {
        $siteModel = Mockery::mock('BehatEditorServices\SiteModel');
        $user = (object) ['uid' => 1];
        $siteModel->shouldReceive('getSitesForUserId')->once()->andReturn(array(1,2,3));
        $sitesModel = new BehatEditorSitesController($siteModel, $user);
        $output = $sitesModel->index(array('user_id' => 10));
        $this->assertEquals(array(1,2,3), $output);
    }

    /**
     * Setup sites folder check that the method is there.
     * the model test will cover more
     */
    public function testFolderSetup()
    {
        $siteModel = Mockery::mock('BehatEditorServices\SiteModel');
        $siteModel->shouldReceive('create')->once()->andReturn('/some/path');
        $sitesModel = new BehatEditorSitesController($siteModel);
        $output = $sitesModel->create('5555', array());
        $this->assertEquals('/some/path', $output);
    }
}