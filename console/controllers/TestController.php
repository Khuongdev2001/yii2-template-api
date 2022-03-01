<?php
namespace app\console\controllers;

use app\models\Student;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionTestKhuong()
    {
        $students = Student::find()->one();
        if($students)
        {
            $room = $students->rooms;
            var_dump($room);
        }
    }
}