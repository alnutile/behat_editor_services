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
    public $user;
    protected $type;

    public function __construct(BehatEditorTestsController $behatTestsController = null, FeatureModel $featureModel = null, $user = null)
    {
        parent::__construct();
        $this->type = variable_get('behat_editor_services_site_node_type', 'site');
        $this->user = ($user == null) ? self::getUser() : $user;
        $this->featureModel = ($featureModel == null) ? new FeatureModel() : $featureModel;
    }

    private static function getUser()
    {
        global $user;
        return $user;
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
        ($uid == null) ? $uid = $this->user->uid : null;
        $result = db_query("SELECT * FROM {node} WHERE type LIKE :type AND uid = :uid", array(':type' => $this->type, ':uid' => $uid));
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
        $result = db_query("SELECT * FROM {node} WHERE type LIKE :type", array(':type' => $this->type));
        $nids = [];
        foreach($result as $record) {
            $nids['node'][$record->nid] = $record->nid;
        }

        $this->site = $this->buildNodeArray($nids, $this);
        if(is_array($this->site)) {
            $this->site = array_shift($this->site);
        }
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

        $result = db_query("SELECT * FROM {node} WHERE type LIKE :type AND uuid = :uid", array(':type' => $this->type, ':uid' => $uuid));
        $nids = [];

        foreach($result as $record) {
            $nids['node'][$record->nid] = $record->nid;
        }

        $this->site = $this->buildNodeArray($nids, $this);
        if(is_array($this->site)) {
            $this->site = array_shift($this->site);
        }

        $this->hasManyTests();
        $this->site->full_path = $full_path;
        return $this->preProcessOutput(array($this->site));
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