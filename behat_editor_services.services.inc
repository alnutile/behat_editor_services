<?php
/**
 * @file
 * behat_editor_reports_service.services.inc
 */

/**
 * Implements hook_default_services_endpoint().
 */
function behat_editor_services_default_services_endpoint() {
    $export = array();

    $endpoint = new stdClass();
    $endpoint->disabled = FALSE; /* Edit this to true to make a default endpoint disabled initially */
    $endpoint->api_version = 3;
    $endpoint->name = 'behat_editor_sites';
    $endpoint->server = 'rest_server';
    $endpoint->path = 'behat_editor_services_v2';
    $endpoint->authentication = array(
        'services' => 'services',
    );
    $endpoint->server_settings = array(
        'formatters' => array(
            'json' => TRUE,
            'bencode' => FALSE,
            'jsonp' => FALSE,
            'php' => FALSE,
            'xml' => FALSE,
        ),
        'parsers' => array(
            'application/json' => TRUE,
            'application/x-www-form-urlencoded' => TRUE,
            'application/vnd.php.serialized' => FALSE,
            'application/xml' => FALSE,
            'multipart/form-data' => FALSE,
            'text/xml' => FALSE,
        ),
    );
    $endpoint->resources = array(
        'sites' => array(
            'operations' => array(
                'create' => array(
                    'enabled' => '1',
                ),
                'retrieve' => array(
                    'enabled' => '1',
                ),
                'update' => array(
                    'enabled' => '1',
                ),
                'delete' => array(
                    'enabled' => '1',
                ),
                'index' => array(
                    'enabled' => '1',
                ),
            ),
            'targeted_actions' => array(
                'templates' => array(
                    'enabled' => '1',
                ),
            ),
        ),
    );
    $endpoint->debug = 0;
    $export['behat_editor_services'] = $endpoint;

    return $export;
}
