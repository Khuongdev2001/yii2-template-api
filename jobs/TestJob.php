<?php

namespace app\jobs;
use yii\base\BaseObject;
use app\models\Student;
class TestJob extends BaseObject implements \yii\queue\JobInterface {
    
    public function execute($queue)
    {
        $modelStudent =new Student();
        $modelStudent->student_name="Test Queue";
        $modelStudent->save(false);
    }
}