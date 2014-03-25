<?php namespace BehatEditorServices;

use BehatEditorServices\BehatEditorTestsController;

class SitesRepository extends ServicesRepository {

    public $behatTestsController;
    public $sites;
    public $site;
    public $full_path;
    public $siteModel;
    public $uuid;
    public $featureModel;
    public $eq;

    public function __construct(BehatEditorTestsController $behatTestsController = null, \EntityFieldQuery $eq = null, FeatureModel $featureModel = null)
    {
        parent::__construct();
        $this->eq = ($eq == null) ? new \EntityFieldQuery() : $eq;
        $this->featureModel = ($featureModel == null) ? new FeatureModel() : $featureModel;
    }

    /**
     * Later this will be more about get sites
     * for user in Group but this is just to keep
     * moving on the output
     * @TODO use UUID as for the above
     *
     * @param null $uid
     * @return array
     */
    public function getSitesForUserId($uid = null)
    {
        global $user;
        ($uid == null) ? $uid = $user->uid : null;
        $default = variable_get('behat_editor_services_site_node_type', 'site');
        $result = db_query("SELECT * FROM {node} WHERE type LIKE :type AND uid = :uid", array(':type' => $default, ':uid' => $uid));
        $nids = [];
        foreach($result as $record) {
            $nids['node'][$record->nid] = $record->nid;
        }
        $sites = $this->buildNodeArray($nids, $this);
        return $this->preProcessOutput(array($sites));
    }

    public function getSitesUUIDFromNid($nid)
    {
        $model = $this;
        $query = $this->baseQuery()
            ->propertyCondition('nid', $nid);
        $result = $query->execute();
        $this->site = $this->buildNodeArray($result, $model);
        $this->site = array_shift($this->site);
        return $this;
    }

    public function setSiteNodesFullPath($full_path)
    {
        $this->site->full_path = $full_path;
        return $this;
    }

    public function setSitesPathForTests($full_path)
    {
        $this->site->test_files_root_path = $full_path;
        return $this;
    }

    public function getSiteAndTestsForSiteUUID($params)
    {
        list($uuid, $full_path, $siteModel) = $params;
        $this->uuid = $uuid;
        $this->siteModel = $siteModel;
        $this->full_path = $full_path;
        $query = $this->baseQuery()
            ->propertyCondition('uuid', $this->uuid);
        $result = $query->execute();
        $this->site = $this->buildNodeArray($result, $this);
        $this->site = array_shift($this->site);
        $this->hasManyTests();
        $this->site->full_path = $full_path;
        return $this->preProcessOutput(array($this->site));
    }

    public function baseQuery()
    {

        $this->eq->entityCondition('entity_type', 'node')
            ->entityCondition('bundle', variable_get('behat_editor_services_site_node_type', 'site'))
            ->propertyCondition('status', 1);
        return $this->eq;
    }

    public function setFullPath($full_path)
    {
        $this->full_path = $full_path;
    }

    public function getFullPath()
    {
        return $this->full_path;
    }

    public function hasManyTests()
    {
        $relatedTests = array();
        if(count($this->site)){
            $relatedTests = $this->featureModel->getTestsInPath($this->full_path);
        }
        $this->site->testFiles = $relatedTests;
        return $this;
    }



}