<?php

namespace app\controllers\api;

use Yii;
use yii\rest\ActiveController;
use yii\data\Pagination;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use app\models\Subject;

class SubjectController extends ActiveController 
{
    public $modelClass="app\models\subject";
    
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

    public function actionCreate(){
        $request=Yii::$app->request;
        if(!$request->isPost){
            return $this->responseJson(false,null,"Method not allow",405);
        }
        $modelSubject=new Subject();
        $modelSubject->load($request->post(),"");
        if($modelSubject->validate()){
            $modelSubject->save();
            return $this->responseJson(true,[
                "subject"=>$modelSubject
            ],"Thêm thành công môn học");
        }
        return $this->responseJson(false,$modelSubject->getErrors(),"",500);
    }
    

    public function actionUpdate(){
        $request=Yii::$app->request;
        if(!$request->isPut){
            return $this->responseJson(false,null,"Method not allow",405);
        }
        $modelSubject=new Subject();
        $modelSubject->load($request->getBodyParams(),"");
        if(!$modelSubject->validate()){
            return $this->responseJson(false,$modelSubject->getErrors(),"",500);
        }
        $subject=$modelSubject->findOne(["id"=>$request->get("id")]);
        if($subject){
            $subject->load($request->getBodyParams(),"");
            $subject->update();
            return $this->responseJson(true,[
                "subject"=>$subject
            ],"Cập nhật thành công");
        }
        return $this->responseJson(false,null,"Get id in table subject not found",404);
    }

    /**
     * @param object $request [
     *      id
     * ]
     * @return object response 
     * here is method delete subject by id
     */
    public function actionDelete(){
        $request=Yii::$app->request;
        if(!$request->isDelete){
            return $this->responseJson(false,null,"Method not allow",405);
        }
        $modelSubject= new Subject();
        $subject=$modelSubject->findOne(["id"=>$request->get("id")]);
        if($subject){
            $subject->delete();
            return $this->responseJson(true,null,"Xóa thành công môn học");
        }
        return $this->responseJson(false,null,"Get id in table subject not  found",404);
    }

    /**
     * @param object $request [
     *    id
     * ]
     * @return object response
     * 
     * here is method get subject by id
     */

    public function actionView(){
        $request=Yii::$app->request;
        if(!$request->isGet){
            return $this->responseJson(false,null,"Method not allow",405);
        }
        $modelSubject=new Subject();
        $subject=$modelSubject->findOne(["id"=>$request->get("id")]);
        return $this->responseJson(true,$subject);
    }

    /**
     * @param object $request [
     *    item,
     *    page
     * ]
     * 
     * @return object response [
     * 
     * ]
     * herer is method get all list subject
     */
    
    public function actionIndex(){
        $request=Yii::$app->request;
        if(!$request->isGet){
            return $this->responseJson(false,null,"Method not allow",405);
        }
        $params = $request->get();
        $modelSubject=new Subject();
        $query=$modelSubject->find();
        $countQuery = clone $query;
        $pages = new Pagination([
            "totalCount" => $countQuery->count(),
            "page" => $params["page"] ?? 0,
            "pageSize" => $params["item"] ?? 1
        ]);

        $subjects = $query
        ->select(["id", "name"])
        ->offset($pages->offset)
        ->limit($pages->limit)
        ->all();

        return $this->responseJson(true,[
            "subjects"=>$subjects
        ]);
    }

    public function actions()
    {
        
    }
}