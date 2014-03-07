<?php namespace BehatEditorServices;


/**
 * By using this between my other classes I can
 * then more easily mock the results as needed
 *
 * Class ServicesRepository
 * @package BehatEditorServices
 */
class ServicesRepository {

    public function getSitesForUserId($uid = null)
    {
        global $user;
        ($uid == null) ? $uid = $user->uid : null;
        $query = new \EntityFieldQuery();
        $query->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', variable_get('behat_editor_services_site_node_type', 'site'))
            ->propertyCondition('status', 1)
            ->propertyCondition('uid', $uid);
        $result = $query->execute();
        if (isset($result['node'])) {
            $sites = array_keys($result['node']);
            $sites = entity_load('node', $sites);
        }
        return $sites;
    }


}