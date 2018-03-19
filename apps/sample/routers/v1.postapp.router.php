<?php
// default index action, GET /
$app->post('/signinapp', 'Sample\Controller\UserAppController:actionUsersignin');
//    ->name('post-doctorsignin2');

$app->post('/signupapp', 'Sample\Controller\UserAppController:actionUsersignup');
//    ->name('post-doctorsignin2');

$app->post('/heartdatasearch', 'Sample\Controller\UserAppController:actionHeartdatasearchApp');

$app->post('/mailcheckapp', 'Sample\Controller\UserAppController:actionUserMailcheck');

$app->post('/fmailcheckapp', 'Sample\Controller\UserAppController:actionFUserMailcheck');

$app->post('/chkpwdapp', 'Sample\Controller\UserAppController:actionCheckpwdApp');

$app->post('/changepwdapp', 'Sample\Controller\UserAppController:actionPwdchangeApp');

$app->post('/idcancellationapp', 'Sample\Controller\UserAppController:actionIDCancellationApp');

$app->post('/profileapp', 'Sample\Controller\UserAppController:actionProfileupdateApp');

$app->post('/fpwdchangeapp', 'Sample\Controller\UserAppController:actionFpwdchangeApp');

$app->post('/aqiapp', 'Sample\Controller\DataController:actionAQIDataSearchApp')
    ->name('load-aqidataapp');

$app->post('/heartdataapp', 'Sample\Controller\DataController:actionHeartDataInsertApp')
    ->name('insert-heartdataapp');

$app->post('/aqidataapp', 'Sample\Controller\DataController:actionAQIDataInsertApp')
    ->name('insert-heartdataapp');

$app->post('/heartarrayapp', 'Sample\Controller\DataController:actionHeartArrayInsertApp')
    ->name('insert-heartarrayapp');

$app->post('/aqiarrayapp', 'Sample\Controller\DataController:actionAqiArrayInsertApp')
    ->name('insert-aqiarrayapp');

$app->post('/userlistapp', 'Sample\Controller\UserAppController:actionUserListApp')
    ->name('load-userlistapp');

$app->post('/doctorlistapp', 'Sample\Controller\UserAppController:actionDoctorListApp')
    ->name('load-doctorlistapp');

$app->post('/doctorsearchapp', 'Sample\Controller\UserAppController:actionDoctorsearchApp')
    ->name('search-user');

$app->post('/usersearchapp', 'Sample\Controller\UserAppController:actionPatientsearchApp')
    ->name('search-user');

$app->post('/connectbyuserapp', 'Sample\Controller\UserAppController:actionConnectbyuserApp')
    ->name('connect-patient');

$app->post('/connectbydoctorapp', 'Sample\Controller\UserAppController:actionConnectuserApp')
    ->name('connect-patient');

$app->post('/conrequestbydoctorapp', 'Sample\Controller\UserAppController:actionConrequestApp')
    ->name('connect-request');

$app->post('/conrequestbyuserapp', 'Sample\Controller\UserAppController:actionConrequestbyuserApp')
    ->name('connect-request');

$app->post('/disconnectuserapp', 'Sample\Controller\UserAppController:actionDisconnectuserApp')
    ->name('disconnect-patient');

$app->post('/alluserlistapp', 'Sample\Controller\UserAppController:actionGetuserlistapp')
    ->name('get-userlist');

$app->group('/v1', function () use ($app) {
    // get programmers list, GET /v1/programmers
    $app->get('/programmers', 'Sample\Controller\ProgrammerController:actionGetProgrammers')
        ->name('get-programmers-list');

    // get programmer detail, GET /v1/programmers/:id
    $app->get('/programmers/:id', 'Sample\Controller\ProgrammerController:actionGetProgrammer')
        ->conditions(array('id' => '\d+'))
        ->name('get-programmer-detail');
});