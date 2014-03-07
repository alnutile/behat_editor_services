<?php
/**
 * AngularJS configuration form
 *
 * @param array $form
 * @param array $form_state
 * @return array
 */
function behat_editor_services_admin_form($form, &$form_state) {

    //Which node type
    $type = variable_get('behat_editor_services_site_node_type');
    dpm($type);
    $types = node_type_get_types();
    foreach($types as $key) {
        $nodes[$key->type] = $key->name;
    }
    $form['behat_editor_services_site_node_type'] = array(
        '#type' => 'select',
        '#title' => t('Node type to relate our settings to'),
        '#options' => $nodes,
        '#default_value' => $type,
        '#description' => t("This is the node type like Site that will be used to store all settings around."),
    );

    return system_settings_form($form);
}