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

$app->group('/v1', function () use ($app) {
    // get programmers list, GET /v1/programmers
    $app->get('/programmers', 'Sample\Controller\ProgrammerController:actionGetProgrammers')
        ->name('get-programmers-list');

    // get programmer detail, GET /v1/programmers/:id
    $app->get('/programmers/:id', 'Sample\Controller\ProgrammerController:actionGetProgrammer')
        ->conditions(array('id' => '\d+'))
        ->name('get-programmer-detail');
});