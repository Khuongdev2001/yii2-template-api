<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentRoom]].
 *
 * @see StudentRoom
 */
class StudentRoomQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return StudentRoom[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StudentRoom|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
