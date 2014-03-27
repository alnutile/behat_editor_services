<?php

#use Faker;
use Faker\Provider\DateTime as DateTimeProvider;
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

   $test_files = array('test1.feature', 'test2.feature', 'test3.feature');

   //@TODO make this a query of the db
   $sites = array('Site 1', 'Site 2', 'Site 3', 'Site 4');
   $sites_nids = array(1,2,3,4,5);
   $max = '2014-03-01 12:00:00';
   $min = '2014-01-01 12:00:00';
   while($count <= $rows) {
       //@TODO get faker time to do a min time not just a max so I can use it.
       $times = array('2014-03-02 12:00:00', '2014-03-22 12:00:00', '2014-03-11 12:00:00', '2014-03-21 12:00:00');
       foreach($schema['behat_editor_results']['fields'] as $key => $value) {
           if($key == 'rid') {
               $values[$key] = null;
           } elseif($key == 'created') {
               $values[$key] = $faker->randomElement($times);
           } elseif($key == 'test_name') {
               $values[$key] = $faker->randomElement($test_files);
           }  elseif($key == 'site_id') {
               $values[$key] = $faker->randomElement($sites_nids);
           } elseif($key == 'url') {
               $values[$key] = $faker->url();
           } elseif($key == 'status') {
               $values[$key] = rand(0,1);
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
