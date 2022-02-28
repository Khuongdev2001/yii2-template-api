<?php

namespace app\models;

use Yii;
use \app\models\base\Student as BaseStudent;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "students".
 */
class Student extends BaseStudent
{
    const SCENARIO_UPDATE = "update";
    const SCENARIO_DELETE = "delete";

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
        } else {
            $this->updated_at = time();
        }

        return true;
    }


    public function scenarios()
    {
        /* Đây là Cách Good để khai báo các scenarios */
        $scenarios = parent::scenarios();
        /* Is Field Quan Trọng Lọc Đưa Vào Validate */
        $scenarios[self::SCENARIO_UPDATE] = ["id", "student_name"];
        $scenarios[self::SCENARIO_DELETE] = ["id"];
        return $scenarios;
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
                ["id", "required", "on" => self::SCENARIO_UPDATE],
                ["id", "required", "on" => self::SCENARIO_DELETE],
                ["id", function ($attribute, $params, $validator) {
                    $student_id = \Yii::$app->request->getBodyParam("id");
                    $student = self::findOne(["id" => $student_id]);
                    if ($student) {
                        return true;
                    }
                    return $this->addError($attribute, 'id dont exist');
                }, "on" => self::SCENARIO_UPDATE],
                ["id", function ($attribute, $params, $validator) {
                    $student_id = \Yii::$app->request->getBodyParam("id");
                    $student = self::findOne(["id" => $student_id]);
                    if ($student) {
                        return true;
                    }
                    return $this->addError($attribute, 'id dont exist');
                }, "on" => self::SCENARIO_DELETE]
            ]
        );
    }
}
