<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subjects}}`.
 */
class m220228_044218_create_subjects_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subjects}}', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(255)->notNull(),
            'created_at'=>$this->string(255),
            'updated_att'=>$this->string(255)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subjects}}');
    }
}
