<?php namespace BehatEditorServices;

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

    }

    /**
     * Setup sites folder check
     */
    public function testFolderSetup()
    {
        //1. pass the site id to the method
        //2. then it should make the folder for us
        //   this will be triggered on site (node) create
    }

}