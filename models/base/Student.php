<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "students".
 *
 * @property integer $id
 * @property string $student_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\StudentRoom[] $studentRooms
 * @property string $aliasModel
 */
abstract class Student extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'students';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['student_name'], 'required'],
            [['student_name', 'created_at', 'updated_at'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_name' => 'Student Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudentRooms()
    {
        return $this->hasMany(\app\models\StudentRoom::className(), ['student_id' => 'id']);
    }


    
    /**
     * @inheritdoc
     * @return \app\models\StudentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\StudentQuery(get_called_class());
    }


}