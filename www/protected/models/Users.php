<?php
/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'Users':
 * @property string $id
 * @property string $uuid
 * @property string $name
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Dictonary[] $dictonaries
 */

Yii::import('baseModel.BaseUsers');

class Users extends BaseUsers
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

    public function generateUuid()
    {
        $uuid = sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
            mt_rand( 0, 0xffff ),
            mt_rand( 0, 0x0fff ) | 0x4000,
            mt_rand( 0, 0x3fff ) | 0x8000,
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
        return $uuid;
    }

    protected function setCookies() {
        Yii::app()->request->cookies['uuid'] = new CHttpCookie('uuid', $this->uuid);
        Yii::app()->request->cookies['name'] = new CHttpCookie('name', $this->name);
    }

    public static function createUser($request)
    {
        if (isset($request['name'])) {
            $model = Users::model()->find('LOWER(name)=?', [$request['name']]);
            if (!$model) {
                $model = new Users();
                $model->name = $request['name'];
                if (!$model->save()) {
                    return ['success'=>false, 'error'=>CVarDumper::dumpAsString($model->getErrors())];
                    Yii::app()->end();
                }
            }
            $model->setCookies();
            $login=new LoginForm;
            $login->attributes = [
                'username'=>$model->name,
                'password'=>$model->uuid];
            if($login->validate() && $login->login()) {
                return [
                    'success'=>true,
                    'user'=>['uuid'=>$model->uuid, 'name'=>$model->name, 'login'=>true],
                    'question'=>Dictonary::getQuestion($model->id),
                    'error'=>ErrorAnswers::getCount($model->id),
                    'ok'=>Answers::getCount($model->id, Answers::FLAG_OK),
                ];
            }
        }
        return ['success'=>false, 'error'=>'Не смогли получить данные'];
    }

    protected function beforeValidate()
    {
        if(parent::beforeValidate()===false)
            return false;

        if ($this->isNewRecord) {
            do {
                $uuid = $this->generateUuid();
                $user = Users::model()->find('uuid=?', [$uuid]);
            } while ($user != null);
            $this->uuid = $uuid;
        }
        return true;
    }


    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
