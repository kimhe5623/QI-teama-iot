<?php
// default index action, GET /
$app->post('/signin', 'Sample\Controller\UserController:actionDoctorsignin')
    ->name('post-doctorsignin');

$app->post('/signout', 'Sample\Controller\UserController:actionSignout')
    ->name('post-doctorsignout');

$app->post('/signinapp', 'Sample\Controller\UserAppController:actionUsersignin');
//    ->name('post-doctorsignin2');

$app->post('/signup', 'Sample\Controller\DoctorNPIverifyingController:actionVerifyNPI')
    ->name('post-doctorsignup');

$app->post('/fileupload', 'Sample\Controller\UserController:actionFileUpload')
    ->name('post-FileUpload');

$app->post('/chkpwd', 'Sample\Controller\UserController:actionCheckpwd')
    ->name('post-pwdcheck');

$app->post('/chkpwdprofile', 'Sample\Controller\UserController:actionCheckpwd')
    ->name('post-pwdcheck');

$app->post('/changepwd', 'Sample\Controller\UserController:actionPwdchange')
    ->name('post-pwdchange');

$app->post('/idcancellation', 'Sample\Controller\UserController:actionIDCancellation')
    ->name('delete-id');

$app->post('/forgottenmail', 'Sample\Controller\UserController:actionMail')
    ->name('send-email');

$app->post('/chkemail', 'Sample\Controller\UserController:actionMailcheck')
    ->name('verification-email');

$app->post('/fchangepwd', 'Sample\Controller\UserController:actionFpwdchange')
    ->name('change-password');

$app->post('/profile', 'Sample\Controller\UserController:actionProfileupdate')
    ->name('update-profile');

$app->post('/aqidata', 'Sample\Controller\DataController:actionAQIDatainput')
    ->name('insert-aqidata');

$app->post('/heartdata', 'Sample\Controller\DataController:actionHeartDatainput')
    ->name('update-heartdata');

$app->post('/patientlist', 'Sample\Controller\UserController:actionUsnsession')
    ->name('usn-session');

$app->post('/heartrate', 'Sample\Controller\DataController:actionHeartrateSearch')
    ->name('load-heartdata');

$app->post('/rrrate', 'Sample\Controller\DataController:actionRRrateSearch')
    ->name('load-rrdata');

$app->post('/aqi', 'Sample\Controller\DataController:actionAQIDataSearch')
    ->name('load-aqidata');

$app->post('/signout', 'Sample\Controller\UserController:actionSignout')
    ->name('sign-out');

$app->post('/patientsearch', 'Sample\Controller\UserController:actionPatientsearch')
    ->name('search-patient');

$app->post('/connectuser', 'Sample\Controller\UserController:actionConnectuser')
    ->name('connect-patient');

$app->post('/conrequest', 'Sample\Controller\UserController:actionConrequest')
    ->name('connect-request');

$app->group('/v1', function () use ($app) {
    // get programmers list, GET /v1/programmers
    $app->get('/programmers', 'Sample\Controller\ProgrammerController:actionGetProgrammers')
        ->name('get-programmers-list');

    // get programmer detail, GET /v1/programmers/:id
    $app->get('/programmers/:id', 'Sample\Controller\ProgrammerController:actionGetProgrammer')
        ->conditions(array('id' => '\d+'))
        ->name('get-programmer-detail');
});