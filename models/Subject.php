<?php

namespace app\models;

use Yii;
use \app\models\base\Subject as BaseSubject;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subjects".
 */
class Subject extends BaseSubject
{
    const SCENARIOS_UPDATE="update";

    public function scenarios()
    {
        $scenarios= parent::scenarios();
        $scenarios[self::SCENARIOS_UPDATE]=["name"];
        return $scenarios;
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->created_at=time();
            return true;
        }
        $this->updated_at=time();
        return true;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                
            ]
        );
    }
}
