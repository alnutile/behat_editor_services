<?php namespace BehatEditorServices;

use BehatApp\Persistence;

class ReportModel implements Persistence  {

    private $data = array();

    function persist($data) {
        if(isset($data['rid']) && $data['rid'] > 0) {
            try {
                $rid = $data['rid'];
                unset($data['rid']);
                $rid = db_update("behat_editor_results")
                    ->fields($data)
                    ->condition("rid", $rid, '=')
                    ->execute();
                $result = array('error' => 0, 'message' => "Row Updated", 'data' => $rid);
            }
            //@TODO reearch the Expections to catch
            catch (Exception $e) {
                $result = array('error' => 1, 'message' => $e, 'data' => null);
                return $result;
            }
            return $result;
        } else {
            try {
                $rid = db_insert("behat_editor_results")->fields($data)->execute();
                $result = array('error' => 0, 'message' => "Row added", 'data' => $rid);
            }
            //@TODO reearch the Expections to catch
            catch (Exception $e) {
                $result = array('error' => 1, 'message' => $e, 'data' => null);
                return $result;
            }
        }
        return $result;
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
        $results = db_query("SELECT * FROM {behat_editor_results} WHERE site_id = :sid and test_name LIKE :test_name", array(":sid" => $id, ":test_name" => $name));
        return $results->fetchAll();
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