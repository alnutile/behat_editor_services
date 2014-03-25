<?php namespace BehatEditorServices;

use Mockery;

class BehatEditorTestsControllerTest extends BaseTests {

    public $repo;
    public $siteModel;
    public $testController;
    public $eq;

    public function setUp()
    {
        parent::setUp();
        $site = array(
            'full_path' => '/tmp/fullSitePath',
            'test_files_root_path' => '/tmp/fullSitePath/features',
            'testFiles' => array(
                'test1.feature' => array(
                    'content' => 'Some Test',
                    'name'    => 'test1.feature',
                    'path'    => '/tmp/fullSitePath/features/test1.feature'
                )
            )
        );
//        $featureModel = Mockery::mock('BehatEditorServices\FeatureModel');
//        $BehatServicesHelper = Mockery::mock('BehatEditorServices\BehatServicesHelper');
//        $this->siteModel = Mockery::mock('BehatEditorServices\SiteModel');
//        $BehatHelper = Mockery::mock('BehatApp\BehatHelper');
//        $this->siteModel->shouldReceive('getSitesUUIDFromNid')->once()->andReturn((object) $site);
//        $BehatServicesHelper->shouldReceive('behelper')->once()->andReturn((object) array());
//        $BehatHelper->shouldReceive('replaceDashWithDots')->once()->andReturn('test1.feature');
//        $this->testController = new BehatEditorTestsController($featureModel, $this->siteModel, $BehatServicesHelper);
    }

    /**
     * @TODO trouble mocking the classes I instantiate in behatServiceHelper
     */
    public function testRun()
    {
//        //send the test name and site id
//        $params = ['1', 'tests', 'test1_feature'];
//        $output = $this->testController->run($params);
//        var_dump('Yup');
//        $this->assertArrayHasKey('data', $output);
//        //look for the site uuid and get it's info
//        //from it get the test info and path info to run from
//        //then run
    }
}