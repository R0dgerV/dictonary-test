<?php

/**
 * This is the model class for table "Answers".
 *
 * The followings are the available columns in table 'Answers':
 * @property string $userId
 * @property string $dictonaryId
 * @property string $flags
 * @property string $created
 * @property string $modified
 */
Yii::import('baseModel.BaseAnswers');

class Answers extends BaseAnswers
{

    const FLAG_CURRENT = 1;
    const FLAG_OK = 2;
    const FLAG_ERROR = 4;

    public static function getAllflags()
    {
        return [
            'current'=>self::FLAG_CURRENT,
            'ok'=>self::FLAG_OK,
            'error'=>self::FLAG_ERROR,
        ];
    }

    public function flags()
    {
        return self::getAllflags();
    }

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

    public static function getCount($userId, $flag)
    {
        return Yii::app()->db->createCommand()
            ->select('count(dictonaryId)')
            ->from('Answers')
            ->where('userId = :userId AND flags & '.$flag.' = '.$flag, [':userId'=>$userId])
            ->queryScalar();
    }

    public static function saveAnswer($request) {
        $userId = Yii::app()->user->id;
        if ($userId && isset($request['answerId'])) {
            $currentAnswer = Answers::model()->current()->find('userId=?', [$userId]);
            if ($currentAnswer) {
                $currentAnswer->isCurrent = false;
                if ($request['answerId'] != $currentAnswer->dictonaryId) {

                    $currentAnswer->isError = true;
                    $errAns = new ErrorAnswers();
                    $errAns->userId = $userId;
                    $errAns->dictonaryId = $currentAnswer->dictonaryId;
                    $errAns->answerId = $request['answerId'];
                    if ($errAns->save()) {
                        return [
                            'success'=>true,
                            'reenter'=>true,
                            'error' => $currentAnswer->isError,
                        ];
                        Yii::app()->end();

                    } else {
                        var_dump($errAns->getErrors());
                    }
                } else {
                    $currentAnswer->isOk = true;
                }
                if ($currentAnswer->save()) {
                    return [
                        'success'=>true,
                        'reenter'=>false,
                        'question'=>Dictonary::getQuestion($userId),
                        'error' => $currentAnswer->isError,
                        'ok' => $currentAnswer->isOk
                    ];
                    Yii::app()->end();
                } else {
                    var_dump($currentAnswer->getErrors());
                }
            }
        }
        return ['success'=>false, 'error'=>'ошибка при сохранении ответа'];
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
