<?php

namespace artlosk\tags\models;

use app\modules\auth\models\Auth;
use krok\extend\behaviors\CreatedByBehavior;
use krok\extend\behaviors\LanguageBehavior;
use krok\extend\behaviors\TimestampBehavior;
use krok\extend\interfaces\HiddenAttributeInterface;
use krok\extend\traits\HiddenAttributeTrait;
use artlosk\tags\models\query\TagQuery;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "{{%tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 * @property integer $hidden
 * @property string $language
 * @property integer $createdBy
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property Auth $createdBy0
 */
class Tag extends ActiveRecord implements HiddenAttributeInterface
{
    use HiddenAttributeTrait;

    /**
     * @return array
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'LanguageBehavior' => [
                'class' => LanguageBehavior::class,
            ],
            'TimestampBehavior' => [
                'class' => TimestampBehavior::class,
            ],
            'CreatedByBehavior' => [
                'class' => CreatedByBehavior::class,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency', 'hidden', 'createdBy'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['language'], 'string', 'max' => 8],
            [['hidden'], 'default', 'value' => Tag::HIDDEN_NO],
            [['createdBy'], 'exist', 'skipOnError' => true, 'targetClass' => Auth::className(), 'targetAttribute' => ['createdBy' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тег',
            'frequency' => 'Частота',
            'hidden' => 'Скрыто',
            'language' => 'Язык',
            'createdBy' => 'Автор',
            'createdAt' => 'Создано',
            'updatedAt' => 'Обновлено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy0()
    {
        return $this->hasOne(Auth::className(), ['id' => 'createdBy']);
    }

    /**
     * @inheritdoc
     * @return TagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }

    /**
     * @param $model
     * @param int $limit
     */
    public static function getAllTagsArrayByModel($model, $limit = 30)
    {
        $query = $model::find();
        $query->select([
                'tagId',
                'COUNT(tagId) as frequency',
                Tag::tableName() . '.[[name]]',
            ])
            ->leftJoin(Tag::tableName(), Tag::tableName() . '.[[id]] = ' . $model::tableName() . '.[[tagId]]')
            ->orderBy(['frequency' => SORT_DESC])
            ->groupBy(['tagId']);
        if ($limit) {
            $query->limit($limit);
        }

        $query = clone $query;
        return $query->asArray()->all();
    }
}
