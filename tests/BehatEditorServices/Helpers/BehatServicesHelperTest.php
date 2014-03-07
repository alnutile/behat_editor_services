<?php namespace BehatEditorServices;

use BehatEditorServices\BehatServicesHelper;

class BehatServicesHelperTest extends BaseTests {

    public $beServicesHelper;

    public function setUp()
    {
        parent::setUp();
        $this->beServicesHelper = new BehatServicesHelper();
    }

    public function tearDown()
    {
        parent::tearDown();
        if($this->fileSystem->exists("/tmp/testBase")) {
            $this->fileSystem->remove("/tmp/testBase");
        }
    }

    public function testSetBasePath()
    {
        $path = "/tmp/testBase";
        $this->beServicesHelper->setBasePathOfAllSites($path);
        $this->assertFileExists($path);
    }

    public function testSetBasePathIfExists()
    {
        $path = "/tmp/testBase";
        $this->fileSystem->mkdir($path);
        $this->assertFileExists($path);
        $this->beServicesHelper->setBasePathOfAllSites($path);
    }

    public function testGetBasePathOfAllSites()
    {
        $path = "/tmp/testBase/behat/";
        $this->beServicesHelper->setBasePathOfAllSites($path);
        $this->assertFileExists($path);
        $output = $this->beServicesHelper->getBasePathOfAllSites();
        $this->assertEquals($path, $output);
    }

    public function testGetSiteFolderBasePath()
    {
        $path = "/tmp/testBase/behat/";
        $this->beServicesHelper->setBasePathOfAllSites($path);
        $this->assertFileExists($path);
        $site_path = $path . '123';
        $this->beServicesHelper->setSiteFolderInBasePathUsingSiteId(123);
        $output = $this->beServicesHelper->getSitesFolderInBasePath();
        $this->assertEquals($site_path, $output);
    }


}