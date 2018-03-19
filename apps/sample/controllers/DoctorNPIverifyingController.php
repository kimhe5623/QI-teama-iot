<?php
namespace Sample\Controller;
session_start();

use Sample\Model\UserGetModel;
use Slimvc\Core\Controller;
use Sample\Model\UserModel;

class DoctorNPIverifyingController extends Controller
{
    public function actionVerifyNPI() {

        $bodyData = json_decode($this->getApp()->request->getBody());

        $fname = $bodyData->fname;
        $lname = $bodyData->lname;
        $npicode = $bodyData->npicode;
        $license = $bodyData->license;
        $url = 'https://npiregistry.cms.hhs.gov/api/resultsDemo2/?number='.$npicode;

        $response = file_get_contents($url);
        $npiData = json_decode($response);

        $realLicense = $npiData->results[0]->taxonomies[0]->license;
        $realFname = $npiData->results[0]->basic->first_name;
        $realLname = $npiData->results[0]->basic->last_name;

        if(!strcmp(strtoupper($fname), $realFname) && !strcmp(strtoupper($lname), $realLname) && !strcmp($license, $realLicense)) {
            $chklicense = (new UserGetModel())->chkLicense($license);
            if(!$chklicense) {
                $inputdoctor = (new UserModel())->insertDoctor($bodyData);
                $usn = (new UserGetModel())->getDsn($bodyData->email);
                $insertlicense = (new UserModel())->insertLicense($usn[0]["USN"], $license);

                echo json_encode(array('status' => true, 'message' => 'Success'));
                return;
            }
            else {
                echo json_encode(array('status' => false, 'message' => 'License already exists'));
                return;
            }
        }
        else {
            echo json_encode(array('status' => false, 'message' => 'Incorrect License information'));
            return;
        }


    }

}

?>
