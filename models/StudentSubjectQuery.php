<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[StudentSubject]].
 *
 * @see StudentSubject
 */
class StudentSubjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return StudentSubject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return StudentSubject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
