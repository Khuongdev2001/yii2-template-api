<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use yii\data\Pagination;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use app\models\StudentSubject;

class StudentSubjectController extends ActiveController

{
    public $modelClass = "app\models\StudentSubject";

    public function actionTestQueue()
    {
        Yii::$app->queue->push(new \app\jobs\TestJob);
    }

    public function actionAverage()
    {
        $studentSubjects = StudentSubject::find()
            ->groupBy("student_id")
            ->select([
                "student_id",
                "subject_id",
                "score" => "AVG(`score`)"
            ]);
        $studentSubjects = $studentSubjects->all();
        Yii::$app->queue->push(new \app\jobs\AverageStudentSubjectJob($studentSubjects));
        return $studentSubjects;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if (in_array(Yii::$app->controller->action->id, [
            "create", "update", "delete"
        ])) {
            $behaviors['authenticator'] = [
                'class' => CompositeAuth::class,
                'authMethods' => [
                    HttpBasicAuth::class,
                    HttpBearerAuth::class,
                    QueryParamAuth::class,
                ],
            ];
        }
        return $behaviors;
    }

    /**
     * @param object $request[
     *     student_id
     *     subject_Id
     * ]
     * @return object response
     * 
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            return $this->responseJson(200, null, "Method dont allow", 405);
        }
        $modelStudentSubject = new StudentSubject();
        $modelStudentSubject->load($request->post(), "");
        if ($modelStudentSubject->validate()) {
            $modelStudentSubject->save();
            return $this->responseJson(true, $modelStudentSubject, "Thêm thành công");
        }
        return $this->responseJson(false, $modelStudentSubject->getErrors(), "", 500);
    }

    /**
     * @param object $request[
     *     student_id
     *     subject_id
     *     id
     * ]
     * @return object response
     */

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            return $this->responseJson(200, null, "Method dont allow", 405);
        }
        $modelStudentSubject = new StudentSubject();
        $modelStudentSubject->load($request->post(), "");
        if (!$modelStudentSubject->validate()) {
            return $this->responseJson(false, $modelStudentSubject->getErrors(), "", 500);
        }
        $studentSubject = $modelStudentSubject->findOne(["id" => $request->get("id")]);
        if ($studentSubject) {
            $studentSubject->load($request->post(), "");
            $studentSubject->save();
            return $this->responseJson(true, $modelStudentSubject, "Cập Nhật thành công");
        }
        return $this->responseJson(false, null, "Get id in table subject not found", 404);
    }

    /**
     * @param object $request [
     *     id
     * ]
     * @return object response
     * 
     *here is method get student_subject by id
     */

    public function actionView()
    {
        $request = Yii::$app->request;
        if (!$request->isGet) {
            return $this->responseJson(200, null, "Method dont allow", 405);
        }
        $modelStudentSubject = new StudentSubject();
        $studentSubject = $modelStudentSubject->findOne(["id" => $request->get("id")]);
        return $this->responseJson(true, [
            "studentSubject" => $studentSubject
        ]);
    }

    /**
     * @return object response
     */

    public function actionIndex()
    {
        /**
         * [ 
         *  item: set page size
         *  page: set page current
         * ]
         */
        $request = Yii::$app->request;
        $params = $request->get();
        $query = StudentSubject::find();
        return $this->responseJson(true, $query->all());
        die;
        $countQuery = clone $query;
        $pages = new Pagination([
            "totalCount" => $countQuery->count(),
            "page" => $params["page"] ?? 0,
            "pageSize" => $params["item"] ?? 1
        ]);
        $studentSubjects = $query
            ->select(["student_name", "score", "name as subject"])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        $this->responseJson(true, $studentSubjects, "");
    }


    /**
     * @param object $request[
     *      id
     * ]
     * 
     * @return object response
     * 
     */

    public function actionDelete()
    {
        $request = Yii::$app->request;
        if (!$request->isDelete) {
            return $this->responseJson(200, null, "Method dont allow", 405);
        }
        $modelStudentSubject = new StudentSubject();
        $modelStudentSubject->findOne(["id" => $request->get("id")]);
        if ($modelStudentSubject) {
            $modelStudentSubject->deleteAll(["id" => $request->get("id")]);
            return $this->responseJson(true, null, "Xóa thành công học sinh");
        }
        return $this->responseJson(false, null, "Get id in table subject not found", 404);
    }

    public function actions()
    {
    }
}
