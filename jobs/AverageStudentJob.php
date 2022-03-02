<?php
namespace app\jobs;

use yii\base\BaseObject;
class AverageStudentJob extends BaseObject implements \yii\queue\JobInterface {
    public $studentSubjects;

    public function execute($queue)
    {
        foreach($this->studentSubjects as $studentSubject){
            $studentSubject->student->ranking=$studentSubject->type;
            $studentSubject->student->save();
        }
    }
}