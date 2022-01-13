<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel artlosk\tags\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('system', 'Tag');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
    </div>

    <div class="card-header">
        <p>
            <?= Html::a(Yii::t('system', 'Create'), ['create'], [
                'class' => 'btn btn-success'
            ]) ?>
        </p>
    </div>

    <div class="card-content">

        <?= GridView::widget([
            'tableOptions' => ['class' => 'table'],
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                [
                    'class' => \krok\extend\grid\ActiveColumn::class,
                    'attribute' => 'name',
                ],
                'frequency',
                [
                    'class' => \krok\extend\grid\HiddenColumn::class,
                    'attribute' => 'hidden',
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'createdAt',
                ],
                [
                    'class' => \krok\extend\grid\DatePickerColumn::class,
                    'attribute' => 'updatedAt',
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>

    </div>
</div>
