<?php namespace BehatEditorServices;

use BehatApp\Persistence;

class ReportModel implements Persistence  {

    private $data = array();

    function persist($data) {
        $this->data[] = $data;
    }

    function retrieve($id) {
        $results = db_query("SELECT * FROM {behat_editor_results} WHERE rid = :rid", array(":rid" => $id));
        return $results->fetch();
    }

    function retrieveAll()
    {
        return $this->data;
    }

    public function delete($id)
    {
        foreach($this->data as $key => $value) {
            if($value['rid'] == $id) {
                unset($this->data[$key]);
            }
        }
    }


    public function retrieveBySiteIdAndTestName($id, $name)
    {
        $results = [];
        foreach($this->data as $key) {
            if($key['site_id'] == $id && $key['test_name'] == $name) {
                $results[] = $key;
            }
        }
        return $results;
    }


    public function retrieveBySiteId($id)
    {
        if(is_array($id)) {
            $results = db_query("SELECT * FROM {behat_editor_results} WHERE site_id IN (:sid)", array(":sid" => $id));
        } else {
            $results = db_query("SELECT * FROM {behat_editor_results} WHERE site_id = :sid", array(":sid" => $id));
        }

        return $results->fetchAll();
    }
}