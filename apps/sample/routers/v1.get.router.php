<?php
// default index action, GET /
$app->get('/', 'Sample\Controller\IndexController:actionIndex')
    ->name('get-homepage');

$app->get('/signin', 'Sample\Controller\IndexController:actionSigninPage')
    ->name('get-signinpage');

$app->get('/signup', 'Sample\Controller\IndexController:actionSignupPage')
    ->name('get-signuppage');

$app->get('/signout', 'Sample\Controller\IndexController:actionSignoutPage')
    ->name('get-signoutpage');

$app->get('/chkpwd', 'Sample\Controller\IndexController:actionChkpwdPage')
    ->name('get-pwdchangepage');

$app->get('/chkpwdprofile', 'Sample\Controller\IndexController:actionChkpwdprofilePage')
    ->name('get-pwdchangepage');

$app->get('/changepwd', 'Sample\Controller\IndexController:actionChangepwdPage')
    ->name('get-pwdchangepage2');

$app->get('/successmessage', 'Sample\Controller\IndexController:actionSuccessmessagePage')
    ->name('get-sucessmessage');

$app->get('/maps', 'Sample\Controller\IndexController:actionMapPage')
    ->name('get-mappage');

$app->get('/idcancellation', 'Sample\Controller\IndexController:actionIDCancellationPage')
    ->name('get-idcancellationpage');

$app->get('/forgottenmail', 'Sample\Controller\IndexController:actionMailPage')
    ->name('get-mailpage');

$app->get('/verification', 'Sample\Controller\IndexController:actionVerificationPage')
    ->name('get-verificationpage');

$app->get('/fchangepwd', 'Sample\Controller\IndexController:actionFchangepwdPage')
    ->name('get-fchangepwdpage');

$app->get('/chkemail', 'Sample\Controller\IndexController:actionCheckemailPage')
    ->name('check-email');

$app->get('/realtimeheartrate', 'Sample\Controller\IndexController:actionRealtimeHeartratePage')
    ->name('get-heartratepage');

$app->get('/realtimeaqi', 'Sample\Controller\IndexController:actionRealtimeAQIDataPage')
    ->name('get-heartratepage');

$app->get('/historicalheartrate', 'Sample\Controller\IndexController:actionHistoricalHeartratePage')
    ->name('get-heartratepage');

$app->get('/historicalaqi', 'Sample\Controller\IndexController:actionHistoricalAQIDataPage')
    ->name('get-heartratepage');

$app->get('/realtime', 'Sample\Controller\UserController:actionRealtimePage')
    ->name('get-patientpage');

$app->get('/historical', 'Sample\Controller\UserController:actionHistoricalPage')
    ->name('get-patientpage');

$app->get('/profile', 'Sample\Controller\UserController:actionProfilePage')
    ->name('get-profilepage');

$app->get('/rthr', 'Sample\Controller\DataController:actionRealhrGet')
    ->name('load-realtimehrdata');

$app->get('/rtaqi', 'Sample\Controller\DataController:actionRealaqiGet')
    ->name('load-realtimeaqidata');

$app->get('/aboutus', 'Sample\Controller\IndexController:actionAboutusPage')
    ->name('load-aboutuspage');

$app->group('/v1', function () use ($app) {
    // get programmers list, GET /v1/programmers
    $app->get('/programmers', 'Sample\Controller\ProgrammerController:actionGetProgrammers')
        ->name('get-programmers-list');

    // get programmer detail, GET /v1/programmers/:id
    $app->get('/programmers/:id', 'Sample\Controller\ProgrammerController:actionGetProgrammer')
        ->conditions(array('id' => '\d+'))
        ->name('get-programmer-detail');
});