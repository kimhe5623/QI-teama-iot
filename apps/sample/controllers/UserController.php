<?php
namespace Sample\Controller;
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use Slimvc\Core\Controller;
use Sample\Model\UserModel;
use Sample\Model\UserGetModel;
use Sample\Model\UserUpdateModel;
use Sample\Model\DataModel;

class UserController extends Controller
{
    public function actionSignout()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());

        if($bodyData->status == "sign-out") {
            session_destroy();
            echo json_encode(array('status' => true, 'message' => 'Success'));
            return;
        }
        echo json_encode(array('status' => true, 'message' => 'fail'));
        return;
    }

    public function actionDoctorsignup()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());

        //$inputdoctor = (new UserModel())->getDoctorInsert($email, $pwd, $birth, $gender, $phone, $fname, $lname);
        $inputdoctor = (new UserModel())->insertDoctor($bodyData);

        echo json_encode(array('status' => true, 'message' => 'Success'));
        return;
    }

    public function actionDoctorsignin()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $useremail = $bodyData->useremail;
        $userpassword = $bodyData->userpassword;

        $user = (new UserGetModel())->getDoctorAccount($useremail);

        if ($user) {
            if (password_verify($userpassword, $user[0]["Hashed_PW"])) {
                $_SESSION['status'] = "sign-in";
                $_SESSION['dsn'] = $user[0]["USN"];

                echo json_encode(array('status' => true, 'message' => 'Success'));
                return;
            }
        }
        echo json_encode(array('status' => false, 'message' => 'User name or Password is incorrect'));
    }

    public function actionCheckpwd()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $userpassword = $bodyData->pwd;

        $dsn = $_SESSION['dsn'];

        $user = (new UserGetModel())->getPassword($dsn, $userpassword);

        $truefalse = password_verify($userpassword, $user[0]['Hashed_PW']);

        if ($truefalse) {
            echo json_encode(array('status' => true, 'message' => 'Success'));
            return;
        }
        echo json_encode(array('status' => false, 'message' => 'Password is incorrect'));
    }

    public function actionPwdchange()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $userpassword = $bodyData->pwd;
        //$dsn = $bodyData->dsn;
        $dsn = $_SESSION['dsn'];

        $user = (new UserUpdateModel())->changePassword($dsn, $userpassword);

        echo json_encode(array('status' => true, 'message' => 'Success'));
    }

    public function actionProfilePage()
    {
        //$bodyData = json_decode($this->getApp()->request->getBody());

        $dsn = $_SESSION['dsn'];
        //$dsn = 4;

        $user = (new UserGetModel())->getUserdata($dsn);

        if($user) {
            $data = array('status' => true, 'email' => $user[0]["User_email"], 'fname' => $user[0]["Fname"],
                'lname' => $user[0]["Lname"], 'birth' => $user[0]["Birth"], 'gender' => $user[0]["Gender"], 'phone' => $user[0]["Phone"]);

            $this->getApp()->contentType('text/html');

            $this->render("web/profile.phtml", $data);

            return;
        }
        echo json_encode(array('status' => false, 'message' => 'Error'));
    }

    public function actionIDCancellation() {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $userpassword = $bodyData->pwd;

        $dsn = $_SESSION['dsn'];

        $user = (new UserGetModel())->getPassword($dsn, $userpassword);

        $truefalse = password_verify($userpassword, $user[0]['Hashed_PW']);


        if ($truefalse) {
            $delete = (new UserUpdateModel())->deleteID($dsn);
            session_destroy();
            echo json_encode(array('status' => true, 'message' => 'Success'));
            return;
        }
        echo json_encode(array('status' => false, 'message' => 'Password is incorrect'));
    }

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

    public function actionMail() {

        $bodyData = json_decode($this->getApp()->request->getBody());

        $user = (new UserGetModel())->getDsn($bodyData->email);

        //var_dump($user);
        //exit;

        if($user) {
            date_default_timezone_set('Etc/UTC');

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = 'smtp.gmail.com';
            $mail->Host = gethostbyname('smtp.gmail.com');
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "teamaiot2017@gmail.com";
            $mail->Password = "chosun2018";
            $mail->setFrom('teamaiot2017@gmail.com', 'M');
            $mail->addReplyTo('teamaiot2017@gmail.com', 'M');
            $mail->addAddress($bodyData->email, 'Test');
            $mail->Subject = 'Verification Code';
            //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

            $str = "";
            $p ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $len = strlen($p)-1;

            for($i = 0; $i<12; $i++){
                $str .= $p[rand(0,$len)];
            }
            $mail->Body = 'Verification Code : '.$str;

            //var_dump($mail);
            //exit;
            if (!$mail->send()) {
                echo "Error: $mail->ErrorInfo";
                echo json_encode(array('status' => false, 'message' => 'Fail'));
                return;
            } else {
                $_SESSION['code'] = $str;
                $_SESSION['dsn'] = $user[0]['USN'];
                $_SESSION['codenum'] = 0;
                echo json_encode(array('status' => true, 'message' => 'Success'));
                return;
            }
        }
        echo json_encode(array('status' => false, 'message' => 'There is no Email'));
    }

    public function actionMailcheck() {

        $bodyData = json_decode($this->getApp()->request->getBody());

        $user = (new UserGetModel())->getDsn($bodyData->email);

        if(!$user) {
            date_default_timezone_set('Etc/UTC');

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = 'smtp.gmail.com';
            $mail->Host = gethostbyname('smtp.gmail.com');
            $mail->Port = 587;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPAuth = true;
            $mail->Username = "teamaiot2017@gmail.com";
            $mail->Password = "chosun2018";
            $mail->setFrom('teamaiot2017@gmail.com', 'M');
            $mail->addReplyTo('teamaiot2017@gmail.com', 'M');
            $mail->addAddress($bodyData->email, 'Test');
            $mail->Subject = 'Verification Code';
            //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

            $str = "";
            $p ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $len = strlen($p)-1;

            for($i = 0; $i<12; $i++){
                $str .= $p[rand(0,$len)];
            }
            $mail->Body = 'Verification Code : '.$str;

            //var_dump($mail);
            //exit;
            if (!$mail->send()) {
                //echo "Error: $mail->ErrorInfo";
                echo json_encode(array('status' => false, 'message' => 'You must provide at least one recipient email address'));
                return;
            } else {
                $_SESSION['code'] = $str;
                $_SESSION['codenum'] = 1;
                $_SESSION['email'] = $bodyData->email;
                echo json_encode(array('status' => true, 'message' => 'Success'));
                return;
            }
        }
        echo json_encode(array('status' => false, 'message' => 'You already signed up'));
    }

    public function actionFpwdchange()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $userpassword = $bodyData->pwd;
        $dsn = $_SESSION['dsn'];

        $user = (new UserUpdateModel())->fchangePassword($dsn, $userpassword);

        unset($_SESSION['dsn']);

        echo json_encode(array('status' => true, 'message' => 'Success'));
    }

    public function actionProfileupdate() {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $dsn = $_SESSION['dsn'];

        $updatedoctor = (new UserUpdateModel())->updateDoctor($bodyData, $dsn);

        echo json_encode(array('status' => true, 'message' => 'Success'));
        return;

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

    public function actionPatientPage()
    {
        $dsn = $_SESSION['dsn'];

        $user = (new UserGetModel())->getPatientdata($dsn);

        $count = count($user);

        if($user) {
            for($i=0;$i<$count;$i++) {
                $data[$i] = array('email' => $user[$i]["U_email"], 'fname' => $user[$i]["U_Fname"],
                    'lname' => $user[$i]["U_Lname"], 'birth' => $user[$i]["U_Birth"], 'gender' => $user[$i]["U_Gender"], 'phone' => $user[$i]["U_Phone"], 'usn' => $user[$i]["USN"],
                    'requestingUSN' => $user[$i]["requestingUSN"], 'requestedUSN' => $user[$i]["requestedUSN"], 'CONN_state' => $user[$i]["CONN_state"]);
            }
            $this->getApp()->contentType('text/html');
            $this->render("web/patientlist.phtml",$data);
            return;
        }

        $this->getApp()->contentType('text/html');
        $this->render("web/patientlist.phtml");

        return;
    }

    public function actionUsnsession()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $_SESSION['usn'] = $bodyData->usn;

        echo json_encode(array('status' => true, 'message' => 'Success'));
        return;
    }

    public function actionPatientsearch()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());

        if($bodyData->type == "Name") {
            $user = (new UserGetModel())->getPatientdatabyname($bodyData->value);
            $count = count($user);

            if($user){
                for($i=0;$i<$count;$i++) {
                    $data[$i] = array('email' => $user[$i]["User_email"], 'fname' => $user[$i]["Fname"],
                        'lname' => $user[$i]["Lname"], 'phone' => $user[$i]["Phone"]);
                }
                echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
                return;
            }
        }
        else if($bodyData->type == "Phone") {
            $user = (new UserGetModel())->getPatientdatabyphone($bodyData->value);

            if($user){
                echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
                return;
            }
        }

        echo json_encode(array('status' => true, 'message' => 'fail'));
        return;
    }

    public function actionConnectuser()
    {
        $bodyData = json_decode($this->getApp()->request->getBody());

        $user = (new UserUpdateModel())->updateConnect($bodyData->usn, $bodyData->dsn);

        echo json_encode(array('status' => true, 'message' => 'Success'));
    }
}