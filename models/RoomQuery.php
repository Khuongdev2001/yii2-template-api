<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Room]].
 *
 * @see Room
 */
class RoomQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Room[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Room|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
