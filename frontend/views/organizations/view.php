<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Organizations */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Organizations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="organizations-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Пополнить баланс', ['history-of-balance/up', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Списывать баланс', ['history-of-balance/down', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            'sum',
        ],
    ]) ?>


    <?= GridView::widget([
        'dataProvider' => $historyOfBalance,
        //'filterModel' => $searchHistoryOfBalance,
        'rowOptions' => function ($model, $key, $index, $grid) {
            if($model->sum > 0){
                return ['class' => 'bg-success'];
            }else{
                return ['class' => 'bg-danger'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'sum',
            'description',
            //'created_at',
            [
                'attribute'=>'created_at',

                'content'=>function($model){
                    return date( 'd.m.Y H:i:s', $model->created_at );
                }
            ],
        ],
    ]); ?>

</div>
