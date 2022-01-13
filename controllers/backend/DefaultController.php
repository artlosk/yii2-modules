<?php

namespace artlosk\tags\controllers\backend;

use artlosk\tags\models\Tag;
use krok\system\components\backend\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\filters\VerbFilter;
use artlosk\tags\models\search\TagSearch;

/**
 * Class DefaultController
 * @package artlosk\tags\controllers\backend
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCheckTag($item)
    {
        if ($item != '') {
            $modelTag = Tag::find()->where(['name' => $item])->one();
            if ($modelTag === null) {
                $modelTag = new Tag(['name' => $item]);
                $modelTag->save();
                $data = ['id' => $modelTag->id, 'name' => $modelTag->name];
                return $this->asJson(['success' => true, 'record' => $data]);
            }
        }

        return $this->asJson(['success' => false]);

    }

    public function actionListTag($q)
    {
        $data = [];
        if ($q != '') {
            $data = Tag::find()->select(['id', 'name'])->where(['like', 'name', $q])->hidden()->asArray()->all();
        }
        return json_encode($data);
    }

    public function actionGetCurrentTags($ids)
    {
        $ids = explode(',', $ids);
        $data = Tag::find()->where(['id' => $ids])->asArray()->all();
        return $this->asJson($data);
    }

    /**
     * Lists all Tag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tag model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tag();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tag::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
