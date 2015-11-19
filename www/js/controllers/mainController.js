(function (angular) {
    'use strict';

    function MainController($scope, $window, ngNotify, MainService) {

        $scope.data = angular.fromJson($window.data);
        $scope.saveName = function(valid) {
            $scope.nameForm.$submitted = true;
            if (valid) {
                MainService.saveName($scope.data.user.name).then(function(data)
                {
                    if (data.success == true) {
                        $scope.data.user = data.user;
                        $scope.data.question = data.question;
                        $scope.data.error = data.error;
                        $scope.data.ok = data.ok;
                    }
                    else {
                        ngNotify.set('Ошибка при coхранении: ' + data.error, 'error');
                    }
                });
            }
        };

        $scope.saveAnswer = function(valid) {
            if (valid) {
                MainService.saveAnswer($scope.selectAnswers).then(function(data)
                {
                    console.log(data);
                    if (data.success == true) {
                        if (data.reenter) {
                            data.error?$scope.data.error++:null;
                            if ($scope.data.error < 3) {
                                ngNotify.set('Ответ не верный, повторите еще раз', 'error');
                            }
                        } else {
                            data.ok?$scope.data.ok++:null;
                            $scope.data.question = data.question;
                        }
                        $scope.selectAnswers = null;
                    }
                    else {
                        ngNotify.set('Ошибка при coхранении: ' + data.error, 'error');
                    }
                });
            }
        };

        $scope.showFinal = function() {
            if (parseInt($scope.data.error) > 2) {
                return true;
            } else {
                return (parseInt($scope.data.countQuestions) <= (parseInt($scope.data.error) + parseInt($scope.data.ok)))?true:false;
            }

        }
    }


    function MainService($http, $q)
    {
        return ({
            saveName: saveName,
            loadQuestion: loadQuestion,
            saveAnswer: saveAnswer
        });

        function loadQuestion()
        {
            var request = $http({
                method: 'get',
                url: '/user/getQuestion/',
            });
            return (request.then(handleSuccess, handleError));
        }

        function saveAnswer(answerId)
        {
            var request = $http({
                method: 'post',
                url: '/user/saveAnswer',
                data: {
                    answerId: answerId
                }
            });
            return (request.then(handleSuccess, handleError));
        }

        function saveName(name)
        {
            var request = $http({
                method: 'post',
                url: '/site/createUser',
                data: {
                    name: name
                }
            });
            return (request.then(handleSuccess, handleError));
        }


        function handleError(response) {
            if (!angular.isObject(response.data) ||
                !response.data.message
            ) {return ($q.reject('An unknown error occurred.'));}
            return ($q.reject(response.data));
        }

        function handleSuccess(response) {
            return (response.data);
        }

    }

    angular.module('App').controller('mainController',['$scope', '$window', 'ngNotify', 'MainService', MainController]);
    angular.module('App').service('MainService', ['$http', '$q', MainService]);

})(angular);
