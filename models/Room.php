<?php

namespace app\models;

use Yii;
use \app\models\base\Room as BaseRoom;
use yii\helpers\ArrayHelper;
use app\behavior\ModelBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "rooms".
 */
class Room extends BaseRoom
{

    const SCENARIO_UPDATE = "update";
    const SCENARIO_DELETE = "delete";
    public $room;


    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
            return true;
        }
        $this->updated_at = time();
        return true;
    }

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                [
                    "class" => ModelBehavior::class,
                    "action" => 34343
                ],
                [
                    'class' => TimestampBehavior::class,
                    'attributes' => [
                        ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                        ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                    ],
                ]
            ]
        );
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = ["id", "name"];
        $scenarios[self::SCENARIO_DELETE] = ["id"];
        return $scenarios;
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
                ["id", "required", "on" => self::SCENARIO_UPDATE],
                ["id", "required", "on" => self::SCENARIO_DELETE],
                ["id", function ($attribute) {
                    $id = \Yii::$app->request->getBodyParam("id");
                    $room = self::findOne(["id" => $id]);
                    if ($room) {
                        $this->room = $room;
                        return true;
                    }
                    $this->addError($attribute, "id dont exist");
                }, "on" => self::SCENARIO_UPDATE],
                ["id", function ($attribute) {
                    $id = \Yii::$app->request->getBodyParam("id");
                    $room = self::findOne(["id" => $id]);
                    if ($room) {
                        $this->room = $room;
                        return true;
                    }
                    $this->addError($attribute, "id dont exist");
                }, "on" => self::SCENARIO_DELETE]
            ]
        );
    }
}
