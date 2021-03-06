<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */


namespace frontend\widgets;


use common\models\Setting;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class DMCA
 * @package frontend\widgets
 */
class DMCA extends widget
{
    public $image='//images.dmca.com/Badges/dmca-badge-w100-5x1-06.png';

    /**
     * @inheritdoc
     */
    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub
        if(!empty($dmca=Setting::getValue('dmca'))){
            $this->registerJs();
            echo Html::a(
                Html::img($this->image.'?ID='.$dmca, ['alt'=>'DMCA.com Protection Status']),
                '//www.dmca.com/Protection/Status.aspx'.'?ID='.$dmca,
                ['title'=>'DMCA.com Protection Status', 'class'=>'dmca-badge', 'target'=>'_blank']
            );
        }
    }

    /**
     * register JS
     */
    public function registerJs(){
        $js=<<<EOB
(function() {
    var d = document, s = d.createElement("script");
    s.src = "//images.dmca.com/Badges/DMCABadgeHelper.min.js";
    (d.head || d.body).appendChild(s);
})();
EOB;
        $this->view->registerJs($js);
    }
}