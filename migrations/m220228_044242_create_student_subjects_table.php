<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student_subjects}}`.
 */
class m220228_044242_create_student_subjects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%student_subjects}}', [
            'id' => $this->primaryKey(),
            'student_id'=>$this->integer()->notNull(),
            'score'=>$this->double(10)->notNull(),
            'created_at'=>$this->string(200),
            'updated_at'=>$this->string(200)
        ]);

        $this->createIndex("idx-student_subjects-student_id","student_subjects","student_id");
        $this->addForeignKey("fk-student_subjects-student_id","student_subjects","student_id","students","id");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%student_subjects}}');
    }
}
