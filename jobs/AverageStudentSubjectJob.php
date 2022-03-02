<?php

namespace app\jobs;

use yii\base\BaseObject;
use app\models\Student;

class AverageStudentSubjectJob extends BaseObject implements \yii\queue\JobInterface
{
    public $studentSubjects;

    public function __construct($studentSubjects)
    {
        $this->studentSubjects = $studentSubjects;
    }

    public function execute($queue)
    {
        foreach ($this->studentSubjects as $studentSubject) {
            if ($studentSubject->score <= 5) {
                $studentSubject->student->ranking="Trung bình";
                $studentSubject->student->update();
                return;
            }
            else if ($studentSubject->score <= 7.9){
                $studentSubject->student->ranking="Khá";
                $studentSubject->student->update();
                return;
            }
            else if ($studentSubject->score <= 10){
                $studentSubject->student->ranking="Giỏi";
                $studentSubject->student->update();
                return;
            }
        }
    }
}
