<?php namespace BehatEditorServices;

use BehatEditorServices\SitesRepository;
use Mockery;


function variable_get() {
    return "site";
}

function db_query() {
    $node = (object) [];
    $node->nid  = '10';
    $node->uuid = '94790c7d-5682-4710-afc6-c36c502cc3c3';
    return array(1 => $node);
}

function entity_load() {
    $entity = (object) array('nid' => 10, 'uuid' => '94790c7d-5682-4710-afc6-c36c502cc3c3');
    $entity->full_path = '/var/www';
    return $entity;
}

class SitesRepositoryTest extends BaseTests {

    function setUp()
    {
        parent::setUp();
        $nodes = array(
            array(),
            array()
        );
        $user = (object) ['uid' => 1];
        $eq = Mockery::mock('\EntityFieldQuery');

        $this->repo = new SitesRepository(Mockery::mock('BehatEditorServices\BehatEditorTestsController'));
    }

    function testGetSitesForUserId()
    {
        $output = $this->repo->getSitesForUserId(1);
        $this->assertNotEmpty($output);
    }

    function testGetSiteUUIDFromNid()
    {
        $this->repo->getSitesUUIDFromNid(10);
        //var_dump($this->repo->site);
        $this->assertEquals('94790c7d-5682-4710-afc6-c36c502cc3c3', $this->repo->site->uuid, "UUID Key missing");
    }

    function testgetSiteAndTestsForSiteUUID()
    {
        $this->fileSystem->mkdir('/tmp/tests/features/');
        $siteModel = (object) [];
        $this->repo->getSiteAndTestsForSiteUUID(['94790c7d-5682-4710-afc6-c36c502cc3c3', '/tmp/tests', $siteModel]);
        $this->assertEquals('94790c7d-5682-4710-afc6-c36c502cc3c3', $this->repo->site->uuid, "UUID Key missing");
    }




}