Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist contrib/yii2-tags "*"
```

or add

```
"contrib/yii2-tags": "*"
```

to the require section of your `composer.json` file.

Description
------------
Теги для любого модуля

Использовались поведения yii2-taggable и они перенесены в модуль
https://github.com/creocoder/yii2-taggable

- Подключение в файле app/config/backend.php

```
    'tag' => [
        'class' => \artlosk\tag\Module::class,
        'controllerNamespace' => 'artlosk\tag\controllers\backend',
        'viewPath' => '@vendor/contrib/yii2-tag/views/backend',
    ],
```

- Подключение в файле app/config/console.php

```
    'migrate' => [
        'class' => \yii\console\controllers\MigrateController::class,
        'migrationTable' => '{{%migration}}',
        'interactive' => false,
        'migrationPath' => [
            @vendor/contrib/yii2-tag/migrations',
        ],
    ],
```

- Подключение в файле app/config/params.php

```
    'menu' => [
        [
            'label' => 'Tag',
            'url' => ['/tag'],
        ],
    ],
```

- Подключение поведения в модели (например Review)

```
    'TagBehavior' => [
        'class' => TaggableBehavior::className(),
         'tagValuesAsArray' => false,
         'tagRelation' => 'tags',
         'tagValueAttribute' => 'id',
         'tagFrequencyAttribute' => 'frequency',
    ],
```

- Подключение поведения в модели запросов (например ReviewQuery)

```
    public function behaviors()
    {
        return [
            TaggableQueryBehavior::className(),
        ];
    }
```

- Правила

```
    public function rules()
    {
        return [
            ['tagValues', 'safe'],
        ];
    }
```

- Создание таблицы в вашем модуле (Отношение многие ко многим) (например Review relation Tag)

```
    $this->createTable('{{%review_rel_tag}}', [
        'id' => $this->primaryKey(),
        'reviewId' => $this->integer(11)->notNull(),
        'tagId' => $this->integer(11)->notNull(),
    ], $options);

    $this->addForeignKey(
        'fk-review_rel_tag-to-review',
        '{{%review_rel_tag}}',
        'reviewId',
        '{{%review}}',
        'id',
        'CASCADE',
        'CASCADE'
    );

    $this->addForeignKey(
        'fk-review_rel_tag-to-tag',
        '{{%review_rel_tag}}',
        'tagId',
        '{{%tag}}',
        'id',
        'CASCADE',
        'CASCADE'
    );
```

- Создание метода

```
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tagId'])
            ->viaTable('{{%review_rel_tag}}', ['reviewId' => 'id']);
    }
```

- Вызов виджета (важно чтобы id был tags-input)

```
    <?= $form->field($model, 'tagValues')->widget(TagBackendWidget::className(), [
        'options' => [
            'id' => 'tags-input',
        ],
    ]) ?>
```