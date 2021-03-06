<?php
namespace common\components;

use codemix\localeurls\UrlManager;
use Yii;

/**
 * LocaleUrl
 *
 */
class LocaleUrl extends UrlManager
{
    public $languages=['en-US'];
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
//        $languages=[];
//        if(Yii::$app->params['settings']['languages']){
//            foreach(Yii::$app->params['settings']['languages'] as $lang=>$name){
//                $languages[]=$lang;
//            }
//        }
//        $this->languages=$languages;
        if (is_a(Yii::$app, '\yii\web\Application')) {
            if(!Yii::$app->user->isGuest){
                $this->enableLanguageDetection=false;
                $this->enableLanguagePersistence=false;
            }
        }

        parent::init();
    }
}
