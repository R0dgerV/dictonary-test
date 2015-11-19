<?php

/**
 * This is the model class for table "Dictonary".
 *
 * The followings are the available columns in table 'Dictonary':
 * @property string $id
 * @property string $nameEn
 * @property string $nameRu
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Users[] $users
 */

Yii::import('baseModel.BaseDictonary');

class Dictonary extends BaseDictonary
{

    public function behaviors()
    {
        return array(
            'autoModifiedBehavior'=>array(
                'class'=>'TSAutoModifiedBehavior',
                'Created'=>'created',
                'Modified'=>'modified',
                'Unixtime'=>false
            ),
        );
    }

    public static function getQuestion($userId = null)
    {
        if ($userId) {

            $db = Yii::app()->db;
            $_question = [];
            $all = [];
            $fields = ((float)rand()/(float)getrandmax())>0.5?['answer'=>'nameRu as answer', 'question'=>'nameEn']:['answer'=>'nameEn as answer', 'question'=>'nameRu'];

            $currentAnswer = Answers::model()->current()->find('userId=?', [$userId]);
            if ($currentAnswer === null) {
                $_question = $db->createCommand('SELECT id,'.implode(',',$fields).' FROM `Dictonary` WHERE id NOT IN (SELECT dictonaryId From Answers WHERE userId = '.(int)$userId.') ORDER BY RAND() LIMIT 1;')->queryRow();
                if (isset($_question['id'])) {
                    $currentAnswer = new Answers();
                    $currentAnswer->userId = $userId;
                    $currentAnswer->dictonaryId = $_question['id'];
                    $currentAnswer->isCurrent = true;
                    if ($currentAnswer->save() ===  false) {
                        var_dump($currentAnswer->getErrors());
                    }
                }
            } else {
                $_question = $db->createCommand('SELECT id,'.implode(',',$fields).' FROM `Dictonary` WHERE id = '.$currentAnswer->dictonaryId)->queryRow();
            }
            if (count($_question)>0) {
                $question = $_question[$fields['question']];
                unset($_question[$fields['question']]);
            }

            $all = $db->createCommand()
                ->select('id,'.$fields['answer'])
                ->from('Dictonary')
                ->where('id!=:userId', array(':userId'=>$_question['id']))
                ->order('RAND()')
                ->limit(3)
                ->queryAll();
            $all[] = $_question;
            shuffle($all);
            shuffle($all);
            if (count($_question)>0 && count($all)>0) {
                return [
                    'success'=>true,
                    'question'=>$question,
                    'answers'=>$all,
                    'error'=>ErrorAnswers::getCount(Yii::app()->user->id),
                    'ok'=>Answers::getCount($userId, Answers::FLAG_OK),
                ];
            } else {
                return [
                    'success'=>true,
                    'question'=>false,
                    'answers'=>false,
                    'error'=>ErrorAnswers::getCount(Yii::app()->user->id),
                    'ok'=>Answers::getCount($userId, Answers::FLAG_OK),
                ];
            }
        } else {
            return ['success'=>false];
        }
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
