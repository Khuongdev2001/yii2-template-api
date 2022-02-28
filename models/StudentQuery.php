<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Student]].
 *
 * @see Student
 */
class StudentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Student[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Student|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
