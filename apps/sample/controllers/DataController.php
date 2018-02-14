<?php
namespace Sample\Controller;
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use Slimvc\Core\Controller;
use Sample\Model\UserModel;
use Sample\Model\DataModel;

class DataController extends Controller
{
    public function actionFileUpload() {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $imagename = $_FILES['Imagefile']['name'];
        $target = 'images/'.$imagename;
        $tmp_name = $_FILES['Imagefile']['tmp_name'];

        /*echo json_encode(array('status' => true, 'message' => 'Success', 'data' => getcwd()));
        return;*/

        if (move_uploaded_file($tmp_name,$target)) {

            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $target));

        } else {

            echo json_encode(array('status' => true, 'message' => 'Fail'));

        }
    }

    public function actionAQIDatainput() {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $insert = (new DataModel())->insertAQIData($bodyData);

        echo json_encode(array('status' => true, 'message' => 'Success'));
        return;
    }

    public function actionHeartDatainput() {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $insert = (new DataModel())->insertHeartData($bodyData);

        echo json_encode(array('status' => true, 'message' => 'Success'));
        return;
    }

    public function actionGetHeartData() {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $usn=$bodyData->usn;

        $insert = (new DataModel())->getHeartData($usn);

        echo json_encode(array('status' => true, 'message' => 'Success'));
        return;
    }

    public function actionHeartratePage()
    {
        $usn=$_SESSION['usn'];
        //$usn=1;

        $user = (new DataModel())->getHeartdata($usn);

        $count=count($user);

        if($user) {
            for($i=0;$i<$count;$i++) {
                $data[$i] = array('ts' => $user[$i]["TS"], 'heartrate' => $user[$i]["Heart_rate"]);
            }

            //var_dump($data);
            //exit;

            $this->getApp()->contentType('text/html');
            $this->render("web/heartrate.phtml",$data);
            return;
        }

        $this->getApp()->contentType('text/html');

        $this->render("web/heartrate.phtml");
    }

    public function actionHeartrateSearch()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());
        $usn=$_SESSION['usn'];

        $fdate = $bodyData->fdate;
        $ldate = $bodyData->ldate;

        $data = (new DataModel())->searchHeartdata($usn, $fdate, $ldate);

        if($data) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
    }

    public function actionRRrateSearch()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());
        $usn=$_SESSION['usn'];

        $fdate = $bodyData->fdate;
        $ldate = $bodyData->ldate;

        $data = (new DataModel())->searchRRdata($usn, $fdate, $ldate);

        if($data) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
    }

    public function actionAQIDataSearch()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());
        $usn = $_SESSION['usn'];

        $fdate = $bodyData->fdate;
        $ldate = $bodyData->ldate;

        $data = (new DataModel())->searchAQIdata($usn, $fdate, $ldate);

        if($data) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
    }
}