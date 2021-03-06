<?php


use common\Core;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel \common\models\MessageSearch|\common\models\MessageSearch */
/* @var $languages [] */
/* @var $availableExport [] */


$this->title = Yii::t('app', 'Languages');
$keywords = '';
$description = '';

//$this->registerMetaTag(['name' => 'keywords', 'content' => $keywords]);
//$this->registerMetaTag(['name' => 'description', 'content' => $description]);
//$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex, nofollow, nosnippet, noodp, noarchive, noimageindex']);

/* Facebook */
//$this->registerMetaTag(['property' => 'og:title', 'content' => $this->title]);
//$this->registerMetaTag(['property' => 'og:description', 'content' => $description]);
//$this->registerMetaTag(['property' => 'og:type', 'content' => '']);
//$this->registerMetaTag(['property' => 'og:image', 'content' => '']);
//$this->registerMetaTag(['property' => 'og:url', 'content' => '']);
//$this->registerMetaTag(['property' => 'fb:app_id', 'content' => '']);
//$this->registerMetaTag(['property' => 'fb:admins', 'content' => '']);

/* Twitter */
//$this->registerMetaTag(['name'=>'twitter:title', 'content'=>$this->title]);
//$this->registerMetaTag(['name'=>'twitter:description', 'content'=>$description]);
//$this->registerMetaTag(['name'=>'twitter:card', 'content'=>'summary']);
//$this->registerMetaTag(['name'=>'twitter:site', 'content'=>'']);
//$this->registerMetaTag(['name'=>'twitter:image', 'content'=>'']);
//$this->registerMetaTag(['name'=>'twitter:data1', 'content'=>'']);
//$this->registerMetaTag(['name'=>'twitter:label1', 'content'=>'']);
//$this->registerMetaTag(['name'=>'twitter:data2', 'content'=>'']);
//$this->registerMetaTag(['name'=>'twitter:label2', 'content'=>'']);

/* breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['/i18n']];
$this->params['breadcrumbs'][] = $this->title;
//$this->registerJs('$(document).on("pjax:send", function(){ $("#loading").modal("show");});$(document).on("pjax:complete", function(){ $("#loading").modal("hide");})');
$this->registerJs('$(document).on("pjax:send", function(){ $(".grid-view-overlay").removeClass("hidden");});$(document).on("pjax:complete", function(){ $(".grid-view-overlay").addClass("hidden");})');
//$js=file_get_contents(__DIR__.'/index.min.js');
//$this->registerJs($js);
$css = file_get_contents(__DIR__ . '/index.css');
$this->registerCss($css);

?>
<div class="i18n-message-index">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#translation" data-toggle="tab" aria-expanded="true"><?= Yii::t('app', 'Translation') ?></a></li>
            <li class=""><a href="#export" data-toggle="tab" aria-expanded="false"><?= Yii::t('app', 'Export') ?></a></li>
            <li class=""><a href="#import" data-toggle="tab" aria-expanded="false"><?= Yii::t('app', 'Import') ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="translation">
                <div class="box box-widget" style="box-shadow: none">
                    <div class="box-body">
                    <?php Pjax::begin(['id' => 'message-translation-wrap']); ?>
                    <?= GridView::widget([
                        'id' => 'i18n-message-grid',
                        'options' => ['class' => 'grid-view table-responsive'],
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'language',
                                'value' => 'language',
                                'filter' => \common\models\Message::getLocaleList()
                            ],
                            [
                                'attribute' => 'category',
                                'value' => 'category',
                                'filter' => \common\models\Message::getCategoryList()
                            ],
                            ['attribute' => 'message', 'value' => 'message'],
                            ['attribute' => 'translation', 'format' => 'raw', 'value' => function ($model) {
                                return \powerkernel\jeditable\Editable::widget([
                                    'content' => strip_tags($model->translation),
                                    'saveUrl' => Yii::$app->urlManager->createUrl(['/i18n/save-translation']),
                                    'options' => ['id' => 'message_' . $model->id . '_' . $model->language, 'class' => 'jeditable-text'],
                                    'clientOptions' => [
                                        'tooltip' => Yii::t('app', 'Click to edit'),
                                        'indicator' => Yii::t('app', 'Saving...'),
                                        'width' => '93%',
                                    ]
                                ]);
                            },
                                //'contentOptions'=>['class'=>'jeditable-text']
                            ],
                            ['attribute' => 'is_translated', 'value' => function ($model) {
                                return Core::getYesNoText($model->is_translated);
                            }, 'filter' => Core::getYesNoOption()],
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{delete}'
                                //'contentOptions'=>['style'=>'min-width: 70px']
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                    <div>
                        <?= \yii\helpers\Html::beginForm(Yii::$app->urlManager->createUrl(['/i18n/add']), 'post', ['class' => 'form-inline']) ?>
                        <div class="form-group">
                            <label for="language"><?= Yii::t('app', 'Language') ?></label>
                            <?= \yii\helpers\Html::dropDownList('language', null, $languages, ['class' => 'form-control']) ?>
                        </div>
                        <button type="submit" class="btn btn-success"><?= Yii::t('app', 'Add') ?></button>
                        <?= \yii\helpers\Html::endForm() ?>
                    </div>
                </div>
                <!-- Loading (remove the following to stop the loading)-->
                <div class="overlay grid-view-overlay hidden">
                    <?= \powerkernel\fontawesome\Icon::widget(['prefix'=>'fas', 'name' => 'sync-alt', 'styling'=>'fa-spin']) ?>
                </div>
                </div>
            </div>


            <div class="tab-pane" id="export">
                <div class="row">
                <?php foreach($availableExport as $export):?>
                    <div class="col-sm-4">
                        <div class="box box-primary box-address">
                            <div class="box-header with-border">
                                <div class="text-uppercase"><strong><?= $export['title'] ?></strong></div>
                            </div>
                            <div class="box-body">
                                <?php foreach ($export['cats'] as $cat):?>
                                    <a href="<?= Yii::$app->urlManager->createUrl(['i18n/export', 'lang'=>$export['lang'], 'cat'=>$cat]) ?>" class="label label-primary"><?= $cat ?></a>
                                <?php endforeach;?>
                            </div>
                        </div>
                    </div>
                <?php endforeach;?>
                </div>
            </div>

            <div class="tab-pane" id="import">
                Import languages coming soon!
            </div>

        </div>
        <!-- /.tab-content -->
    </div>


</div>
