<?php namespace BehatEditorServices;

class BehatEditorBatchesController extends BaseController {
    public function create($params, $request){
        return [1,2,3,'batch'];
    }

    public function update($args, $params)
    {
        return array(1,2,3,'update batches');
    }
}