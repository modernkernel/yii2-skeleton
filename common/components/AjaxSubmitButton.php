<?php
/**
 * @author Harry Tang <harry@powerkernel.com>
 * @link https://powerkernel.com
 * @copyright Copyright (c) 2017 Power Kernel
 */


namespace common\components;


use Yii;
use yii\bootstrap\Html;
use yii\bootstrap\Widget;

/**
 * Class AjaxSubmitButton
 * @package common\components
 */
class AjaxSubmitButton extends Widget
{

    public $text='Submit';
    public $callback=''; // success javascript callback
    public $options;

    public function init()
    {
        parent::init();
        if(!empty($this->options['class'])){
            $this->options['class']='ajax-pds '.$this->options['class'];
        }
        else {
            $this->options['class']='ajax-pds';
        }

        $this->registerJs();

    }

    /**
     * run
     */
    public function run()
    {
        parent::run(); // TODO: Change the autogenerated stub
        echo Html::submitButton(
            \powerkernel\fontawesome\Icon::widget(['icon'=>'refresh fa-spin hidden']).'<span>'.$this->text.'</span>',
            $this->options
        );
    }

    /**
     * register js
     */
    protected function registerJs(){
        $js=<<<EOB
var ajaxForm = $("button.ajax-pds").parents("form:first");ajaxForm.on("beforeSubmit", function(event){ $(ajaxForm).find(":submit").find("i").removeClass("hidden");$(ajaxForm).find(":submit").find("span").addClass("hidden");$(ajaxForm).find(":submit").attr("disabled", "disabled");var formData = ajaxForm.serialize();$.ajax({url: ajaxForm.attr("action"),type: ajaxForm.attr("method"),data: formData,success: function (data) {{$this->callback}},error: function () { $(ajaxForm).find(":submit").find("i").addClass("hidden"); $(ajaxForm).find(":submit").find("span").removeClass("hidden");}});}).on("submit", function(event){event.preventDefault();});
EOB;
        $view = Yii::$app->getView();
        $view->registerJs($js);
    }
}