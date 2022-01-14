<?php

namespace frontend\controllers;

use frontend\models\HistoryOfBalance;
use frontend\models\HistoryOfBalanceSearch;
use frontend\models\Organizations;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HistoryOfBalanceController implements the CRUD actions for HistoryOfBalance model.
 */
class HistoryOfBalanceController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }



    /**
     * Finds the HistoryOfBalance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return HistoryOfBalance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HistoryOfBalance::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUp($id)
    {

        $model = new HistoryOfBalance();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if($model->updateSumUp($id)){
                    return $this->redirect(['organizations/view', 'id' => $id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('up', [
            'model' => $model,
        ]);
    }


    public function actionDown($id){
        $model = new HistoryOfBalance();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                if($model->updateSumDown($id)){

                    return $this->redirect(['organizations/view', 'id' => $id]);
                }else{
                    return $this->redirect(['organizations/view', 'id' => $id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('down', [
            'model' => $model,
        ]);
    }
}
