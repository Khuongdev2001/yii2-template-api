<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%student_rooms}}`.
 */
class m220226_135119_create_student_rooms_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%student_rooms}}', [
            'id' => $this->primaryKey(),
            'student_id' => $this->integer()->notNull(),
            'room_id' => $this->integer()->notNull(),
            'created_at'=>$this->string(200),
            'updated_at'=>$this->string(200)
        ]);

        $this->createIndex("idx-student_rooms-student_id",'student_rooms','student_id');
        $this->addForeignKey("fk-student_rooms-student_id","student_rooms",'student_id','students','id');
        // create foreign rooms
        $this->createIndex("idx-student_rooms-room_id",'student_rooms','room_id');
        $this->addForeignKey('fx-student_rooms-room_id','student_rooms','room_id','rooms','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%student_rooms}}');
    }
}
