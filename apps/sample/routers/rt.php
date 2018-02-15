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

$app->get('/heartrate', 'Sample\Controller\IndexController:actionHeartratePage')
    ->name('get-heartratepage');

$app->get('/rrrate', 'Sample\Controller\IndexController:actionRRratePage')
    ->name('get-heartratepage');

$app->get('/aqi', 'Sample\Controller\IndexController:actionAQIDataPage')
    ->name('get-heartratepage');

$app->get('/patientlist', 'Sample\Controller\UserController:actionPatientPage')
    ->name('get-patientpage');

$app->get('/profile', 'Sample\Controller\UserController:actionProfilePage')
    ->name('get-profilepage');

$app->post('/signin', 'Sample\Controller\UserController:actionDoctorsignin')
    ->name('post-doctorsignin');

$app->post('/signout', 'Sample\Controller\UserController:actionSignout')
    ->name('post-doctorsignout');

$app->post('/signinapp', 'Sample\Controller\UserAppController:actionUsersignin');
//    ->name('post-doctorsignin2');

$app->post('/signupapp', 'Sample\Controller\UserAppController:actionUsersignup');
//    ->name('post-doctorsignin2');

$app->post('/heartdatasearch', 'Sample\Controller\UserAppController:actionHeartdatasearchApp');

$app->post('/mailcheckapp', 'Sample\Controller\UserAppController:actionUserMailcheck');

$app->post('/fmailcheckapp', 'Sample\Controller\UserAppController:actionFUserMailcheck');

$app->post('/chkpwdapp', 'Sample\Controller\UserAppController:actionCheckpwdApp');

$app->post('/changepwdapp', 'Sample\Controller\UserAppController:actionPwdchangeApp');

$app->post('/signup', 'Sample\Controller\UserController:actionDoctorsignup')
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

$app->post('/idcancellationapp', 'Sample\Controller\UserAppController:actionIDCancellationApp');

$app->post('/profileapp', 'Sample\Controller\UserAppController:actionProfileupdateApp');

$app->post('/fpwdchangeapp', 'Sample\Controller\UserAppController:actionFpwdchangeApp');

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