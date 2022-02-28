<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%students}}`.
 */
class m220228_044124_add_ranking_column_to_students_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%students}}', 'ranking', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%students}}', 'ranking');
    }
}
