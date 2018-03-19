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
        //$bodyData = json_decode($this->getApp()->request->getBody());

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

    public function actionAQIDataSearchApp()
    {
        $usn = $_POST['usn'];
        $fdate = $_POST['fdate'];
        $ldate = $_POST['ldate'];

        $data = (new DataModel())->searchAQIdata($usn, $fdate, $ldate);

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        if($data) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
    }

    public function actionRealhrSearch()
    {
        $usn=$_SESSION['usn'];
        $data = (new DataModel())->searchRealhrdata($usn);

        if($data) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
    }

    public function actionRealaqiSearch()
    {
        $usn = $_SESSION['usn'];
        $data = (new DataModel())->searchRealaqidata($usn);

        if($data) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
    }

    public function actionHeartDataInsertApp()
    {
        $usn = $_POST['USN']; $ts = $_POST['TS']; $lat =  $_POST['LAT']; $lng = $_POST['LNG']; $heart = $_POST['HEART_RATE']; $rr = $_POST['RR_RATE'];

        $truefalse = (new DataModel())->insertHeartDataApp($usn, $ts, $lat, $lng, $heart, $rr);

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        if($truefalse) {
            echo json_encode(array('status' => true, 'message' => 'Success'));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
        return;
    }

    public function actionAQIDataInsertApp() {

        $usn = $_POST['usn']; $ts = $_POST['ts']; $lat =  $_POST['lat']; $lng = $_POST['lng']; $co = $_POST['co']; $so2 = $_POST['so2']; $no2 = $_POST['no2']; $o3 = $_POST['o3'];
        $pm25 = $_POST['pm25']; $tem = $_POST['tem'];

        $truefalse = (new DataModel())->insertAQIDataApp($usn, $ts, $lat, $lng, $co, $so2, $no2, $o3, $pm25, $tem);

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        if($truefalse) {
            echo json_encode(array('status' => true, 'message' => 'Success'));
            return;
        }
        echo json_encode(array('status' => true, 'message' => 'Fail'));
        return;
    }

    public function actionHeartArrayInsertApp() {
        //$bodyData = json_decode($this->getApp()->request->getBody());

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        $bodyData = json_decode($_POST['data']);
        $data = $bodyData->data;
        $length = intval($bodyData->length);

        for($i=0; $i<$length; $i++) {
            $truefalse = (new DataModel())->insertHeartDataApp($data[$i]->usn, $data[$i]->ts, $data[$i]->lat, $data[$i]->lng, $data[$i]->heart_rate, $data[$i]->rr_rate);
            if(!$truefalse) {
                echo json_encode(array('status' => true, 'message' => 'Fail', 'data' => $data[$i], 'index' => $i));
                return;
            }
        }
        echo json_encode(array('status' => true, 'message' => 'Success'));
        return;
    }

    public function actionAqiArrayInsertApp() {

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        $bodyData = json_decode($_POST['data']);
        $data = $bodyData->data;
        $length = intval($bodyData->length);

        for($i=0; $i<$length; $i++) {
            $truefalse = (new DataModel())->insertAQIDataApp($data[$i]->usn, $data[$i]->ts, $data[$i]->lat, $data[$i]->lng,
                $data[$i]->co, $data[$i]->so2, $data[$i]->no2, $data[$i]->o3, $data[$i]->pm25, $data[$i]->tem);
            if(!$truefalse) {
                echo json_encode(array('status' => true, 'message' => 'Fail', 'data' => $data[$i], 'index' => $i));
                return;
            }
        }
        echo json_encode(array('status' => true, 'message' => 'Success'));
        return;
    }

    public function actionRealhrGet()
    {
        $usn=$_SESSION['usn'];
        $data = (new DataModel())->getRealhrdata($usn);

        if($data) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
    }

    public function actionRealaqiGet()
    {
        $usn = $_SESSION['usn'];

        $data = (new DataModel())->getRealaqidata($usn);

        if($data) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
    }


}