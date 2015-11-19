<?php

class UserController extends Controller
{

    public function init()
    {
        $this->layout = false;
        header('Content-Type: application/json');
    }

    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + s1aveAnswer', // we only allow deletion via POST request
        );
    }

	public function actionGetQuestion()
	{
        echo CJSON::encode(Dictonary::getQuestion(Yii::app()->user->id));
	}

    public function actionSaveAnswer()
    {
        $request = CJSON::decode(file_get_contents('php://input'));
        if ($request) {
            echo CJSON::encode(Answers::saveAnswer($request));
        }
    }


}