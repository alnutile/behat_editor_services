<?php namespace BehatEditorServices;

use Mockery;

class BaseTests extends \PHPUnit_Framework_TestCase {

    public $sitesController;
    public $testsController;
    public $reportsController;
    public $batchesController;
    public $tagsController;
    public $tokensController;


    function setUp()
    {
      parent::setUp();
      $this->sitesController              = Mockery::mock('BehatEditorSitesController');
      $this->testsController              = Mockery::mock('BehatEditorTestsController');
      $this->reportsController            = Mockery::mock('BehatEditorReportsController');
      $this->batchesController            = Mockery::mock('BehatEditorBatchesController');
      $this->tagsController               = Mockery::mock('BehatEditorTagsController');
      $this->tokensController             = Mockery::mock('BehatEditorTokensController');
    }

    function testGo()
    {

    }

}