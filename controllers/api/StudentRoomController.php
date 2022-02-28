<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use app\models\StudentRoom;
use yii\data\Pagination;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class StudentRoomController extends ActiveController
{

    public $modelClass = "app\models\StudentRoom";

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

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            return $this->responseJson(200, null, "Method dont allow", 405);
        }
        $modelStudentRoom = new StudentRoom();
        $modelStudentRoom->load($request->post(), "");
        if ($modelStudentRoom->validate()) {
            $modelStudentRoom->save();
            return $this->responseJson(200, [
                "student_room" => $modelStudentRoom
            ]);
        }
        return $this->responseJson(false, $modelStudentRoom->getErrors(), "", 500);
    }

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if (!$request->isPut) {
            return $this->responseJson(false, null, "Method dont allow", 405);
        }
        $modelStudentRoom = new StudentRoom();
        $modelStudentRoom->load($request->getBodyParams(), "");
        /* check validate */
        if (!$modelStudentRoom->validate()) {
            return $this->responseJson(false, $modelStudentRoom->getErrors(), "", 500);
        }
        /* get student_room by id */
        $studentRoom = $modelStudentRoom->findOne(["id", $request->get("id")]);
        if ($studentRoom) {
            /* overwrite field database got */
            $studentRoom->load($request->getBodyParams(), "");
            $studentRoom->save();
            return $this->responseJson(true, [
                "student_room" => $studentRoom
            ], "Cập nhật thành công");
        }
        return $this->responseJson(false, null, "Id dont exist in student_rooms table", 500);
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;
        if (!$request->isDelete) {
            return $this->responseJson(false, null, "Method dont allow", 405);
        }
        $modelStudentRoom = new StudentRoom();
        $studentRoom = $modelStudentRoom->findOne(["id" => $request->get("id")]);
        if ($studentRoom) {
            $studentRoom->delete();
            return $this->responseJson(true, null, "Xóa thành công học sinh trong trường", 200);
        }
        return $this->responseJson(false, null, "Id dont exist in student_rooms table", 500);
    }


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
        $query = StudentRoom::find();
        $query->leftJoin("rooms", "`rooms`.`id`=`student_rooms`.`room_id`");
        $query->leftJoin("students", "`students`.`id`=`student_rooms`.`student_id`");
        $countQuery = clone $query;
        $pages = new Pagination([
            "totalCount" => $countQuery->count(),
            "page" => $params["page"] ?? 0,
            "pageSize" => $params["item"] ?? 1
        ]);
        $models = $query
            ->select(["students.*", "rooms.*"])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        /* Phải dùng asArray() mới ra key chuẩn */
        $this->responseJson(true, $query->asArray()->all(), "");
    }

    public function actionView()
    {
        $request = Yii::$app->request;
        $studentRooms = StudentRoom::find()
            ->select(["students.*", "rooms.*"])
            ->leftJoin("rooms", "`rooms`.`id`=`student_rooms`.`room_id`")
            ->leftJoin("students", "`students`.`id`=`student_rooms`.`student_id`")
            ->where("student_rooms.id", $request->get("id"));
        $studentRooms = $studentRooms->asArray()->one();

        return $this->responseJson((bool)$studentRooms, [
            "student_rooms" => $studentRooms
        ], "");
    }

    public function actions()
    {
    }
}
