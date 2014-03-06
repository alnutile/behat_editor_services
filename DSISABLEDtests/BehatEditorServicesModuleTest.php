<?php namespace BehatEditorServices;

function composer_manager_register_autoloader(){

}

function drupal_json_output() {

}

class BehatEditorServicesModuleTest extends BaseTests {


    public function testNoArgsAndGET()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $output = behat_editor_services_rest();
        $this->assertEquals("You are here", $output);
    }
}
