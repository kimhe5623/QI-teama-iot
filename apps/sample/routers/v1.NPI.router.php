<?php

$app->get('/npiverifying', 'Sample\Controller\DoctorNPIverifyingController:actionVerifyNPI')
    ->name('get-npiverify');

?>
    
