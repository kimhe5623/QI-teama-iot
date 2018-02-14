<?php
namespace Sample\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Slimvc\Core\Controller;
use Sample\Model\UserModel;
use Sample\Model\UserGetModel;
use Sample\Model\UserUpdateModel;
use Sample\Model\DataModel;

class UserAppController extends Controller
{
    public function actionUsersignup()
    {
        if (!isset($_POST['email']) || !isset($_POST['pwd']) || !isset($_POST['fname']) || !isset($_POST['lname']) || !isset($_POST['birth']) || !isset($_POST['gender']) || !isset($_POST['phone'])) {
            echo json_encode(array('message' => 'Something is missing'));
            $this->getApp()->stop();
        }

        $email = $_POST['email'];
        $pwd = $_POST['pwd'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $birth = $_POST['birth'];
        $gender = $_POST['gende r'];
        $phone = $_POST['phone'];

        $user = (new UserModel())->insertUser($email, $pwd, $fname, $lname, $birth, $gender, $phone);

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        echo json_encode(array('message' => 'Success'));
    }

    public function actionUsersignin()
    {
        if (!isset($_POST['useremail']) || !isset($_POST['userpassword']) || !isset($_POST['who'])) {
            echo json_encode(array('message' => 'User name or Password is incorrect'));
            $this->getApp()->stop();
        }

        $useremail = $_POST['useremail'];
        $userpassword = $_POST['userpassword'];
        $who = $_POST['who'];

        $user = (new UserGetModel())->getUserAccount($useremail, $who);

        if ($user) {
            if (password_verify($userpassword, $user[0]["Hashed_PW"])) {
                $this->getApp()->response->headers->set('Content-Type', 'application/json');
                $this->getApp()->status(200);

                echo json_encode(array('message' => 'Success', 'usn' => $user[0]["USN"], 'email' => $useremail, 'fname' => $user[0]["Fname"], 'lname' => $user[0]["Lname"]));
            }
        }
    }

    public function actionUserMailcheck() {

        $email=$_POST['email'];

        if (!isset($email)) {
            echo json_encode(array('message' => 'Something is missing'));
            $this->getApp()->stop();
        }

        $user = (new UserGetModel())->getUserEmail($email);

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
            $mail->addAddress($email, 'Test');
            $mail->Subject = 'Verification Code';
            //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

            $str = "";
            $p ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $len = strlen($p)-1;

            for($i = 0; $i<12; $i++){
                $str .= $p[rand(0,$len)];
            }
            $mail->Body = 'Verification Code : '.$str;

            $this->getApp()->response->headers->set('Content-Type', 'application/json');
            $this->getApp()->status(200);

            if (!$mail->send()) {
                echo "Error: $mail->ErrorInfo";
                echo json_encode(array('status' => false, 'message' => 'Fail'));
                return;
            } else {

                echo json_encode(array('status' => true, 'message' => 'Success', 'code' => $str));
                return;
            }
        }
        echo json_encode(array('status' => false, 'message' => 'Fail'));
    }

    public function actionCheckpwdApp()
    {
        if (!isset($_POST['pwd']) || !isset($_POST['usn'])) {
            echo json_encode(array('message' => 'Something is missing'));
            $this->getApp()->stop();
        }

        $userpassword = $_POST['pwd'];
        $usn = $_POST['usn'];

        $user = (new UserGetModel())->getDataApp($usn);

        $truefalse = password_verify($userpassword, $user[0]['Hashed_PW']);

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        if ($truefalse) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'email' => $user[0]['User_email'], 'fname' => $user[0]['Fname'],
                'lname' => $user[0]['Lname'], 'birth' => $user[0]['Birth'], 'phone' => $user[0]['Phone']));
            return;
        }
        echo json_encode(array('status' => false, 'message' => 'Password is incorrect'));
    }

    public function actionPwdchangeApp()
    {
        if (!isset($_POST['pwd']) || !isset($_POST['usn'])) {
            echo json_encode(array('message' => 'Something is missing'));
            $this->getApp()->stop();
        }

        $userpassword = $_POST['pwd'];
        $usn = $_POST['usn'];

        $user = (new UserUpdateModel())->changePassword($usn, $userpassword);

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        echo json_encode(array('status' => true, 'message' => 'Success'));
    }

    public function actionIDCancellationApp() {

        if (!isset($_POST['pwd']) || !isset($_POST['usn'])) {
            echo json_encode(array('message' => 'Something is missing'));
            $this->getApp()->stop();
        }

        $userpassword = $_POST['pwd'];
        $usn = $_POST['usn'];

        $user = (new UserGetModel())->getPassword($usn, $userpassword);

        $truefalse = password_verify($userpassword, $user[0]['Hashed_PW']);


        if ($truefalse) {
            $delete = (new UserUpdateModel())->deleteID($usn);

            $this->getApp()->response->headers->set('Content-Type', 'application/json');
            $this->getApp()->status(200);

            echo json_encode(array('status' => true, 'message' => 'Success'));
            return;
        }
        echo json_encode(array('status' => false, 'message' => 'Password is incorrect'));
    }

    public function actionProfileupdateApp() {

        if (!isset($_POST['birth']) || !isset($_POST['usn']) || !isset($_POST['fname']) || !isset($_POST['lname']) || !isset($_POST['phone'])) {
            echo json_encode(array('message' => 'Something is missing'));
            $this->getApp()->stop();
        }
        $usn = $_POST['usn']; $fname = $_POST['fname']; $lname = $_POST['lname']; $birth = $_POST['birth']; $phone = $_POST['phone'];

        $updatedoctor = (new UserUpdateModel())->updateUser($usn,$fname,$lname,$birth,$phone);

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        echo json_encode(array('status' => true, 'message' => 'Success'));
        return;

    }

    public function actionFpwdchangeApp()
    {
        if (!isset($_POST['pwd']) || !isset($_POST['usn'])) {
            echo json_encode(array('message' => 'Something is missing'));
            $this->getApp()->stop();
        }

        $userpassword = $_POST['pwd'];
        $usn = $_POST['usn'];

        $user = (new UserUpdateModel())->fchangePassword($usn, $userpassword);

        $this->getApp()->response->headers->set('Content-Type', 'application/json');
        $this->getApp()->status(200);

        echo json_encode(array('status' => true, 'message' => 'Success'));
    }

    public function actionFUserMailcheck() {

        $email=$_POST['email'];

        if (!isset($email)) {
            echo json_encode(array('message' => 'Something is missing'));
            $this->getApp()->stop();
        }

        $user = (new UserGetModel())->getUserEmailUSN($email);

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
            $mail->addAddress($email, 'Test');
            $mail->Subject = 'Verification Code';
            //$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

            $str = "";
            $p ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $len = strlen($p)-1;

            for($i = 0; $i<12; $i++){
                $str .= $p[rand(0,$len)];
            }
            $mail->Body = 'Verification Code : '.$str;

            $this->getApp()->response->headers->set('Content-Type', 'application/json');
            $this->getApp()->status(200);

            if (!$mail->send()) {
                echo "Error: $mail->ErrorInfo";
                echo json_encode(array('status' => false, 'message' => 'Fail'));
                return;
            } else {

                echo json_encode(array('status' => true, 'message' => 'Success', 'code' => $str, 'usn' => $user[0]['USN']));
                return;
            }
        }
        echo json_encode(array('status' => false, 'message' => 'Fail'));
    }

    public function actionHeartdatasearchApp()
    {
        if (!isset($_POST['usn'])) {
            echo json_encode(array('message' => 'USN is missing'));
            $this->getApp()->stop();
        }
        $usn = $_POST['usn'];

        $fdate = $_POST['fdate'];
        $ldate = $_POST['ldate'];

        $data = (new DataModel())->searchHeartdata($usn, $fdate, $ldate);

        if($data) {
            echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
            return;
        }

        echo json_encode(array('status' => true, 'message' => 'Fail'));
    }

}