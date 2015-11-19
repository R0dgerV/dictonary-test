<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$cs = Yii::app()->getClientScript();
$cs->registerScriptFile('/js/controllers/mainController.js', CClientScript::POS_END);

?>
<div ng-cloak class="ng-cloak" id="mc" ng-app="App" ng-controller="mainController">
    <div ng-show="data.user.login">
        <a class="text-right" href="/site/logout">Выход</a>
    </div>

    <div ng-show="data.user.login === false">
        <h2>Вам предлагают пройти тест!</h2>
        <ng-form name="nameForm" class="form-horizontal">
            <div class="form-group" ng-class="{'has-error': (nameForm.user_name.$invalid && (nameForm.user_name.$dirty  || nameForm.$submitted))}">
                <label for="enterName" class="col-sm-2 control-label">Ваше Имя</label>
                <div class="col-sm-10">
                    <input autocomplete="off" type="text" ng-model="data.user.name" name="user_name" class="form-control" id="enterName" placeholder="Введите Ваше Имя" required>
                    <div ng-messages="nameForm.user_name.$error" ng-if="nameForm.user_name.$dirty  || nameForm.$submitted" role="alert" style="color:maroon">
                        <div ng-message="required">Вы должны заполнить поле!</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" ng-click="saveName(nameForm.$valid)" class="btn btn-success">Начать тест</button>
                </div>
            </div>
        </ng-form>
    </div>

    <div ng-show="data.user.login && !showFinal()">
        <h2>{{data.user.name}} ответте на следующий вопрос!</h2>
        <div>&nbsp;</div>

            <div class="thumbnail shadow-depth-1" ng-show="data.question.answers.length > 0">
                <div class="caption">
                    <h4>Выберите перевод для слова "<span style="color: #cc0000"><strong>{{data.question.question}}</span></strong>"</h4>
                    <hr>
                    <ng-form name="answersForm">
                        <div ng-repeat="answer in data.question.answers">
                            <input type="radio" name="selectAnswers" ng-model="$parent.selectAnswers" required value="{{answer.id}}">&nbsp;{{answer.answer}}
                        </div>
                    </ng-form>
                    <div>&nbsp;</div>
                    <button ng-disabled="answersForm.$invalid" type="submit" ng-click="saveAnswer(answersForm.$valid)" class="btn btn-success">Ответить на вопрос</button>

                </div>
            </div>
    </div>

    <div ng-show="showFinal()">
        <h2>{{data.user.name}}!</h2>
        <div>&nbsp;</div>

        <div class="thumbnail shadow-depth-1" ng-show="data.question.answers.length > 0">
            <div class="caption" ng-show="data.error > 2">
                Вы совершили больше 2-х ошибок!
            </div>
            <div class="caption" ng-show="data.error < 3">
                Поздравляю Вы прошли тест полностью
            </div>
            <div class="caption">
                Ваш результат: Вы правильно ответили на <strong>{{data.ok}}</strong> вопросов и совершили <strong>{{data.error}}</strong> ошибок!
            </div>
        </div>
    </div>


</div>

<script type="text/javascript" charset="utf-8">
    window.data = <?php echo CJSON::encode($data);?>;
</script>