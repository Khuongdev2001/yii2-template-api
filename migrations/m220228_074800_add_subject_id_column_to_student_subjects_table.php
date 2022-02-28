<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%student_subjects}}`.
 */
class m220228_074800_add_subject_id_column_to_student_subjects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("student_subjects", "subject_id",$this->integer());
        $this->createIndex("idx-student_subjects-subject_id","student_subjects","subject_id");
        $this->addForeignKey("fx-student_subjects-subject_id","student_subjects","subject_id","subjects","id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
