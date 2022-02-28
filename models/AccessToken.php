<?php

namespace app\models;

use Yii;
use \app\models\base\AccessToken as BaseAccessToken;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "access_token".
 */
class AccessToken extends BaseAccessToken
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
