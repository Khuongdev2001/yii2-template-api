<?php

namespace app\models;

use Yii;
use \app\models\base\StudentRoom as BaseStudentRoom;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "student_rooms".
 */
class StudentRoom extends BaseStudentRoom
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }
    

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return $scenarios;
    }

    public function students(){

    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    public function getChildren(){

    }

    public function getRoom(){
        
    }
}
