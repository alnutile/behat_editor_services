<?php namespace BehatEditorServices;

use Mockery;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class BaseTests extends \PHPUnit_Framework_TestCase {

    public $sitesController;
    public $testsController;
    public $reportsController;
    public $batchesController;
    public $tagsController;
    public $tokensController;
    public $fileSystem;
    public $finder;


    function setUp()
    {
      parent::setUp();
      $this->sitesController              = Mockery::mock('BehatEditorSitesController');
      $this->testsController              = Mockery::mock('BehatEditorTestsController');
      $this->reportsController            = Mockery::mock('BehatEditorReportsController');
      $this->batchesController            = Mockery::mock('BehatEditorBatchesController');
      $this->tagsController               = Mockery::mock('BehatEditorTagsController');
      $this->tokensController             = Mockery::mock('BehatEditorTokensController');
      $this->finder                       = new Finder();
      $this->fileSystem                   = new Filesystem();
    }

    function testGo()
    {

    }

}