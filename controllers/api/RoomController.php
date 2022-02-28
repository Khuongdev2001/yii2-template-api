<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use yii\data\Pagination;
use app\models\Room;

class RoomController extends ActiveController
{
    public $modelClass = "app\models\Room";

    public function behaviors()
    {
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
        $behaviors = parent::behaviors();
        return $behaviors;
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
        $query = Room::find();
        $countQuery = clone $query;
        $pages = new Pagination([
            "totalCount" => $countQuery->count(),
            "page" => $params["page"] ?? 0,
            "pageSize" => $params["item"] ?? 1
        ]);
        $models = $query
            ->select(["id", "name"])
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $this->responseJson(true, $models, "");
    }

    public function actionView()
    {
        $request = Yii::$app->request;
        if (!$request->isGet) {
            return $this->responseJson(false, null, "");
        }
        $modelRoom = new Room();
        // use Room::SCENARIO_DELETE So check id exist database
        $room = $modelRoom->findOne(["id" => $request->get("id")]);
        if ($room) {
            return $this->responseJson(true, [
                "room" => $room
            ]);
        }
        return $this->responseJson(false, [
            "id" => "id dont exist"
        ], null, 500);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        if (!$request->isPost) {
            return $this->responseJson(false, [], "Method not allow", 405);
        }
        $roomModel = new Room();
        $roomModel->load($request->post(), "");
        if ($roomModel->validate()) {
            $roomModel->save();
            return $this->responseJson(true, [
                "room" => $roomModel
            ], "", 200);
        }
        return $this->responseJson(false, $roomModel->getErrors(), "", 500);
    }

    public function actionUpdate()
    {
        $request = Yii::$app->request;
        if (!$request->isPut) {
            return $this->responseJson(false, [], "Method not allow", 405);
        }
        $roomModel = new Room();
        $roomModel->scenario = Room::SCENARIO_UPDATE;
        $roomModel->load($request->getBodyParams(), "");
        if ($roomModel->validate()) {
            $roomModel->updateAll($roomModel, ["id" => $request->getBodyParam("id")]);
            return $this->responseJson(true, [
                "room" => $roomModel
            ], "Cập nhật thành công");
        }
        return $this->responseJson(true, $roomModel->getErrors(), "", 500);
    }

    public function actionDelete()
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            return $this->responseJson(false, [], "Method not allow", 405);
        }
        $roomModel = new Room();
        $roomModel->scenario = Room::SCENARIO_DELETE;
        $roomModel->load($request->getBodyParams(), "");
        if ($roomModel->validate()) {
            $roomModel->deleteAll(["id" => $request->getBodyParam("id")]);
            return $this->responseJson(true, null, "Xóa thành công phòng");
        }
        return $this->responseJson(false, $roomModel->getErrors(), "", 500);
    }

    /**
     * @overwrite
     */
    public function actions()
    {
    }
}
