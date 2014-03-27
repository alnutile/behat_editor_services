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
        $content = $this->yml->dump($this->defaultSettingsNotNew());
        $this->fileSystem->dumpFile('/tmp/settings/settings.yml', $content);
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
        $siteRepo = Mockery::mock('BehatEditorServices\SitesRepository');
        $siteRepo->shouldReceive('getSitesForUserId')->once()->andReturn(['node' => [1 => 1, 2 => ['nid' => 1, 'full_path' => '/tmp/settings'], 3 => 3]]);
        $user = (object) ['uid' => 1];
        $beSettings = new BehatEditorSettingsController(null, null, $siteRepo, $user);
        $file = $beSettings->retrieve([2]);
        $this->assertEquals('@notNew', $file['data']['defaults']['default_tag']);
    }

    function testUserNotInSites()
    {
        $siteRepo = Mockery::mock('BehatEditorServices\SitesRepository');
        $siteRepo->shouldReceive('getSitesForUserId')->once()->andReturn(['node' => [1 => 1, 2 => 2, 3 => 3]]);
        $user = (object) ['uid' => 1];
        $beSettings = new BehatEditorSettingsController(null, null, $siteRepo, $user);
        $response = $beSettings->retrieve([200]);
        $this->assertEquals('User does not have access to site', $response['message']);
    }
    //2. putSitesSettings to udpate the content that is there

    function testGetSitesSettingsFileNotThere()
    {
        $siteRepo = Mockery::mock('BehatEditorServices\SitesRepository');
        $siteRepo->shouldReceive('getSitesForUserId')->once()->andReturn(['node' => [1 => 1, 2 => ['nid' => 1, 'full_path' => '/tmp/settings'], 3 => 3]]);
        $user = (object) ['uid' => 1];
        $this->fileSystem->remove('/tmp/settings/settings.yml');
        $beSettings = new BehatEditorSettingsController(null, null, $siteRepo, $user);
        $file = $beSettings->retrieve([2]);
        $this->assertEquals('@example', $file['data']['defaults']['default_tag']);
    }

    function testPutSitesSettings()
    {
        $file = $this->defaultSettingsNotNew();
        $file['defaults']['default_tag'] = '@updated';
        $siteRepo = Mockery::mock('BehatEditorServices\SitesRepository');
        $siteRepo->shouldReceive('getSitesForUserId')->once()->andReturn(['node' => [1 => 1, 2 => ['nid' => 1, 'full_path' => '/tmp/settings'], 3 => 3]]);
        $user = (object) ['uid' => 1];
        $beSettings = new BehatEditorSettingsController(null, null, $siteRepo, $user);
        $beSettings->udpate([2, $file]);
        $file = $beSettings->retrieve([2]);
        $this->assertEquals('@updated', $file['data']['defaults']['default_tag']);
    }

    function testPutRegectedForNonUserMember()
    {
        $file = $this->defaultSettingsNotNew();
        $file['defaults']['default_tag'] = '@updated';
        $siteRepo = Mockery::mock('BehatEditorServices\SitesRepository');
        $siteRepo->shouldReceive('getSitesForUserId')->once()->andReturn(['node' => [1 => 1, 2 => ['nid' => 1, 'full_path' => '/tmp/settings'], 3 => 3]]);
        $user = (object) ['uid' => 1];
        $beSettings = new BehatEditorSettingsController(null, null, $siteRepo, $user);
        $beSettings->udpate([200, $file]);
        $file = $beSettings->retrieve([2]);
        $this->assertNotEquals('@updated', $file['data']['defaults']['default_tag']);
    }

    function testThatSaucelabsGoesIntoYmlandUrl()
    {

    }

    function defaultSettingsNotNew()
    {
        return array(
            'defaults' => [
                'default_tag' => '@notNew',
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