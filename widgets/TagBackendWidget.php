<?php
namespace artlosk\tags\widgets;

use artlosk\tags\widgets\assets\TagBackendAsset;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\InputWidget;

/**
 * Class TagBackendWidget
 * @package artlosk\tags\widgets
 */
class TagBackendWidget extends InputWidget
{

    /**
     * @var ActiveForm
     */
    public $form;

    /**
     * @var ActiveRecord
     */
    public $model;

    /**
     * @return string
     * @throws Exception
     */
    public function run()
    {
        $options = ArrayHelper::merge([
            'maxlength' => true,
            'class' => 'tag form-control',
            'id' => 'tags-input',
        ], $this->options);

        if (!$this->hasModel()) {
            throw new Exception('Model must be set');
        }
        $view = $this->getView();
        TagBackendAsset::register($view);
        return Html::activeInput('text', $this->model, $this->attribute, $options);
    }
}
