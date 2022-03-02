<?php

namespace app\behavior;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class ModelBehavior extends Behavior
{   
    public $action;

    public function init()
    {
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => "beforeValidate"
        ];
    }

    public function beforeValidate()
    {
       
    }
    
}
