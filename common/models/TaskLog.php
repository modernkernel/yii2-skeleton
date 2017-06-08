<?php
/**
 * @author Harry Tang <harry@modernkernel.com>
 * @link https://modernkernel.com
 * @copyright Copyright (c) 2017 Modern Kernel
 */

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%core_cron_job_logs}}".
 *
 * @property integer $id
 * @property string $task
 * @property string $result
 * @property integer $created_at
 * @property integer $updated_at
 */
class TaskLog extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%core_task_logs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task', 'result'], 'required'],
            [['result'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['task'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'task' => Yii::t('app', 'Task'),
            'result' => Yii::t('app', 'Result'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * get task list
     * @return array
     */
    public static function getTaskList(){
        $vendors=['harrytang','modernkernel'];
        $options=[];

        foreach($vendors as $vendor){
            $dir = \Yii::$app->vendorPath . '/'.$vendor;
            if (file_exists($dir)) {
                $modules = scandir($dir);
                foreach ($modules as $module) {
                    if (!preg_match('/[\.]+/', $module)) {
                        $cronjobs = $dir.'/' . $module . '/cronjobs';
                        if (is_dir($cronjobs)) {
                            $tasks = scandir($cronjobs);
                            foreach ($tasks as $task) {
                                if (preg_match('/^(Task\w+).php$/', $task, $match)) {
                                    //require($dir.'/' . $module . '/cronjobs/' . $task);
                                    $name=str_ireplace('.php', '', $task);
                                    $options[$name]=$name;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $options;
    }
}
