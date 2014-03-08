<?php namespace BehatEditorServices;

use BehatEditorServices\SitesRepository;
use Mockery;


function variable_get() {
    return "test";
}

class SitesRepositoryTest extends BaseTests {

    function setUp()
    {
        parent::setUp();
        $this->repo = new SitesRepository(Mockery::mock('BehatEditorServices\BehatEditorTestsController'), Mockery::mock('\EntityFieldQuery'));
    }

    function testGetSitesForUserId()
    {
        $uid = 1;
        $nodes = array(
            array(),
            array()
        );
        $this->repo->eq->shouldReceive('entityCondition->entityCondition->propertyCondition->execute')->once()->andReturn((object) $nodes);
        $output = $this->repo->getSitesForUserId(1);
        var_dump($output);

    }

}