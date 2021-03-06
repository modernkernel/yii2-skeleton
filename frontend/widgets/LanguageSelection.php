<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2016 Power Kernel
 */


namespace frontend\widgets;


use common\models\Message;
use powerkernel\flagiconcss\Flag;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class LanguageSelection
 * @package frontend\widgets
 */
class LanguageSelection extends Widget
{

    //public $type;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->registerCss();
        parent::init(); // TODO: Change the autogenerated stub
    }


    /**
     * @inheritdoc
     */
    public function run()
    {
        //$currentLang=Yii::$app->language;
        $langs = array_reverse(Message::getLocaleList());

        echo Html::beginTag('div', ['class'=>'language-selection']);
        foreach($langs as $code=>$lang){
            $title=locale_get_display_language($code, $code);
            $c=strtolower(substr($code, -2));
            $icon= Flag::widget([
                'tag' => 'span', // flag tag
                'country' => $c, // where xx is the ISO 3166-1-alpha-2 code of a country,
                'squared' => false, // set to true if you want to have a squared version flag
                'options' => [
                    //'class'=>'btn btn-sm btn-default'
                ]
            ]);
            echo Html::a($icon.' '.$title, $this->langUrl($code), ['title'=>$title]);
        }
        echo Html::endTag('div');



    }

    /**
     * register css
     */
    protected function registerCss(){
        $css=<<<EOB
.language-selection a {margin: 0 3px;}
.language-selection a:first-child {margin-left:0;}
.language-selection a:last-child {margin-right:0;}
EOB;
        $this->view->registerCss($css);
    }

    /**
     * get lang url
     * @param $code
     * @return string
     */
    protected function langUrl($code){
        $route[] = Yii::$app->controller->route;
        $params = $_GET;
        $params['lang'] = strtolower($code);
        $p=array_merge($route, $params);
        return Yii::$app->urlManager->createUrl($p);
    }


}