<?php

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model artlosk\tags\models\Tag */
?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'frequency')->textInput() ?>

<?= $form->field($model, 'hidden')->dropDownList($model::getHiddenList()) ?>

