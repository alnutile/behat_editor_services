<?php namespace BehatEditorServices;


use Symfony\Component\Yaml\Yaml;
use Mockery;

function variable_get() {
    return 'site';
}

class BehatEditorSettingsControllerTests extends BaseTests
{
    public $yml;

    function setUp()
    {
        parent::setUp();
        if(!$this->fileSystem->exists('/tmp/settings')) {
            $this->fileSystem->mkdir('/tmp/settings');
        }
        $this->yml = new Yaml();
        $this->yml->dump($this->defaultSettings(), '/tmp/settings');
    }

    function tearDown()
    {
        parent::tearDown();

        if($this->fileSystem->exists('/tmp/settings')) {
            $this->fileSystem->remove('/tmp/settings');
        }

    }
    //1. getSitesSettings to get the files from the sites folder
    function testGetSitesSettings()
    {
        //1. Arrange
        //   Done in Setup
        $siteRepo = Mockery::mock('BehatEditorServices\SitesRepository');
        $siteRepo->shouldReceive('getSitesForUserId')->once()->andReturn(['node' => [1 => 1, 2 => 2, 3 => 3]]);
        $user = (object) ['uid' => 1];
        $beSettings = new BehatEditorSettingsController(null, null, $siteRepo, $user);
        $file = $beSettings->retrieve([2]);
        var_dump($file);
    }

    function testUserNotInSites()
    {
        $siteRepo = Mockery::mock('BehatEditorServices\SitesRepository');
        $siteRepo->shouldReceive('getSitesForUserId')->once()->andReturn(['node' => [1 => 1, 2 => 2, 3 => 3]]);
        $user = (object) ['uid' => 1];
        $beSettings = new BehatEditorSettingsController(null, null, $siteRepo, $user);
        $response = $beSettings->retrieve([200]);
        $this->assertEquals('User does not have permission for this site', $response['message']);
    }
    //2. putSitesSettings to udpate the content that is there

    function testGetSitesSettingsFileNotThere()
    {

    }

    function testThatSaucelabsGoesIntoYmlandUrl()
    {

    }

    function defaultSettings()
    {
        return array(
            'defaults' => [
                'default_tag' => '@example',
                'base_url'    => 'http://google.com'
            ],
            'github' => [
                'github_username' => 'test',
                'github_password' => 'test',
                'test_folder'     => 'tests',
                'github_account'  => 'testuser'
            ],
            'saucelabs' => [
                'browser' => [
                    'username'      => "testuser",
                    'access-key'    => 'accessskey',
                    'browser'       => 'firefox',
                    'os'            => 'Windows 2003',
                    'name'          => "Testing with Saucelabs",
                ],
                'host'          => "ondemand.saucelabs.com",
                'port'          => 80
            ],
        );
    }
}