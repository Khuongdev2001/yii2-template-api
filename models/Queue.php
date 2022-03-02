<?php

namespace app\models;

use Yii;
use \app\models\base\Queue as BaseQueue;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "queue".
 */
class Queue extends BaseQueue
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

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
