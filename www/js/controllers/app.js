(function (angular) {

    angular.module('App', [
        'angular-loading-bar', 'ui.bootstrap', 'ngNotify', 'ngMessages'
    ])
        .config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
            cfpLoadingBarProvider.includeSpinner = false;
            cfpLoadingBarProvider.includeBar = true;
        }])
        .run(['ngNotify', function(ngNotify) {
            ngNotify.config({
                position: 'top',
                duration: 2500,
                type: 'success',
                sticky: false
            })
        }])
    ;

})(angular);


