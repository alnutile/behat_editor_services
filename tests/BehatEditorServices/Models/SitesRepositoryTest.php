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

        $eq = Mockery::mock('\EntityFieldQuery');

        $this->repo = new SitesRepository(Mockery::mock('BehatEditorServices\BehatEditorTestsController'), $eq);
    }

    function testGetSitesForUserId()
    {
        $output = $this->repo->getSitesForUserId(1);
        $this->assertNotEmpty($output);
    }



}