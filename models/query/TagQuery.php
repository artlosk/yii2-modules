<?php

namespace artlosk\tags\models\query;

use Yii;
use yii\helpers\ArrayHelper;
use artlosk\tags\models\Tag;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Tag]].
 *
 * @see Tag
 */
class TagQuery extends ActiveQuery
{
    /**
     * @param null|string $language
     *
     * @return $this
     */
    public function language($language = null)
    {
        if ($language === null) {
            $language = Yii::$app->language;
        }

        return $this->andWhere([Tag::tableName() . '.[[language]]' => $language]);
    }

    /**
     * @inheritdoc
     * @return Tag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param int $hidden
     * @return TagQuery
     */
    public function hidden($hidden = Tag::HIDDEN_NO): TagQuery
    {
        return $this->andWhere([Tag::tableName() . '.[[hidden]]' => $hidden]);
    }

    /**
     * @return array
     */
    public function asDropDown()
    {
        return ArrayHelper::map($this->hidden()->asArray()->all(), 'id', 'title');
    }
}
