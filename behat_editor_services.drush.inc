<?php

#use Faker;

require_once('behat_editor_services.install');
/**
 * @file
 * Drush hook implementations for BehatEditor
 */

/**
 * Implements hook_drush_command().
 */
function behat_editor_services_drush_command() {
    $items = array();

    $items['seed-reports'] = array(
        'description' => 'Seed Reports Table',
        'allow-additional-options' => TRUE,
        'aliases' => array('sr'),
        'examples' => array(
            'drush sr 20' => 'This will see the reports table with 20 rows'
        ),
        'bootstrap' => DRUSH_BOOTSTRAP_DRUPAL_FULL,
        'arguments' => array(
            'number' => 'Number of rows',
        ),
    );

    return $items;
}

function drush_behat_editor_services_seed_reports() {
   if(func_get_arg(0)) { $rows = func_get_arg(0); } else { $rows = 20; }
   $count = 0;
    $schema = behat_editor_services_schema();
    $faker = Faker\Factory::create();
   while($count <= $rows) {
       foreach($schema['behat_editor_results']['fields'] as $key => $value) {
           if($key == 'rid') {
               $values[$key] = null;
           } elseif($key == 'test_name') {
               $values[$key] = getFaker($value['type']);
           }  elseif($key == 'site_id') {
               $values[$key] = rand(1,20);
           } elseif($key == 'url') {
               $values[$key] = $faker->url();
           } elseif($key == 'status') {
               $values[$key] = rand(1,2);
           } else {
               $values[$key] = getFaker($value['type']);
           }
       }
       $record = db_insert('behat_editor_results') // Table name no longer needs {}
           ->fields($values)
           ->execute();
       $count++;
   }
}

function getFaker($type) {
    $faker = Faker\Factory::create();

    switch($type) {
        case int:
            return rand(1,10);
        break;
        case varchar:
            return $faker->word();
        break;
        case blob:
            return $faker->sentence(20);
            break;
        default:
            return $faker->word();
        break;
    }

}
