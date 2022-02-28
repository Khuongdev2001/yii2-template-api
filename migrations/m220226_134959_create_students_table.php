<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%students}}`.
 */
class m220226_134959_create_students_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%students}}', [
            'id' => $this->primaryKey(),
            'student_name'=>$this->string(255)->notNull(),
            'created_at'=>$this->string(255),
            'updated_at'=>$this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%students}}');
    }
}
