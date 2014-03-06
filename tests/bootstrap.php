<?php
$autoloadFile   = __DIR__;
$autoloadFile   = explode("/", $autoloadFile);
//$drupal_root    = array_slice($autoloadFile, 0, -6);
//$drupal_root    = implode("/", $drupal_root);
//define('DRUPAL_ROOT', $drupal_root);
//require_once $drupal_root . '/includes/bootstrap.inc';
//$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
//drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
$autoloadFile   = array_slice($autoloadFile, 0, -4);
$autoloadFile   = implode("/", $autoloadFile);
//require_once $autoloadFile . "/modules/contrib/composer_manager/composer_manager.module";
//require_once $autoloadFile . "/modules/custom/behat_editor_services/behat_editor_services.module";
$autoloadFile   = $autoloadFile . "/vendor/autoload.php";

if (!file_exists($autoloadFile)) {
    throw new RuntimeException('Install dependencies to run test suite.');
}
require_once $autoloadFile;

$loader = new \Composer\Autoload\ClassLoader();
$loader->add('BehatEditorServices\\', 'tests/');
$loader->register();
