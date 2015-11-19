<?php

/**
 * This is the model class for table "ErrorAnswers".
 *
 * The followings are the available columns in table 'ErrorAnswers':
 * @property string $userId
 * @property string $dictonaryId
 * @property string $answerId
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Dictonary $answer
 * @property Dictonary $dictonary
 * @property Users $user
 */

Yii::import('baseModel.BaseErrorAnswers');

class ErrorAnswers extends BaseErrorAnswers
{
    public function behaviors()
    {
        return array(
            'autoModifiedBehavior'=>array(
                'class'=>'TSAutoModifiedBehavior',
                'Created'=>'created',
                'Modified'=>null,
                'Unixtime'=>false
            ),
        );
    }

    public static function getCount($userId)
    {
        return Yii::app()->db->createCommand()
            ->select('count(dictonaryId)')
            ->from('ErrorAnswers')
            ->where('userId = :userId', [':userId'=>$userId])
            ->queryScalar();
    }


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
