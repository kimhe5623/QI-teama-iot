<?php
namespace Sample\Model;


use Slimvc\Core\Model;

class UserModel extends Model
{
    public function insertDoctor($data) {

        $sql = "INSERT into USERS (User_email, Hashed_PW, Fname, Lname, Gender, Birth, Phone, Who) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $hashed = password_hash($data->pwd, PASSWORD_DEFAULT);

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($data->email), strval($hashed), strval($data->fname), strval($data->lname), intval($data->gender), strval($data->birth),
            strval($data->phone),intval(1)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function insertUser($email, $pwd, $fname, $lname, $birth, $gender, $phone) {

        $sql = "INSERT into USERS (User_email, Hashed_PW, Fname, Lname, Gender, Birth, Phone, Who) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $hashed = password_hash($pwd, PASSWORD_DEFAULT);

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email), strval($hashed), strval($fname), strval($lname), intval($gender), strval($birth), strval($phone), intval(0)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function insertLicense($usn, $license) {

        $sql = "INSERT into DOCTORS (LicenseNum, USERS_USN) VALUES (?, ?)";


        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($license), intval($usn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function insertAQIData($aqidata) {

        $sql = "INSERT into AQI_HISTORY (CO, SO2, NO2, O3, PM25, Temperature, SSN, TS, LAT, LNG) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(floatval($aqidata->data->co), floatval($aqidata->data->so2), floatval($aqidata->data->no2), floatval($aqidata->data->o3), floatval($aqidata->data->pm2_5),
            floatval($aqidata->data->temperature), intval($aqidata->ssn), strval($aqidata->timestamp), floatval($aqidata->location->lat), floatval($aqidata->location->lng) ));

        return $this->getReadConnection()->lastInsertId();
    }

    public function insertHeartData($heartdata) {

        $sql = "INSERT into HEART_HISTORY (Heart_rate, RR_rate, USN, TS, LAT, LNG) VALUES (?, ?, ?, ?, ?, ?)";
        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(floatval($heartdata->data->Heart_rate), floatval($heartdata->data->RR_rate), intval($heartdata->usn), strval($heartdata->timestamp), floatval($heartdata->location->lat),
            floatval($heartdata->location->lng)));

        return $this->getReadConnection()->lastInsertId();
    }

    /*public function getDoctorAccount($useremail) {

        $sql = "SELECT USN, Hashed_PW FROM USERS WHERE User_email = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($useremail)));

        return $sth->fetchAll();
    }

    public function getUserAccount($useremail) {

        $sql = "SELECT USN, Hashed_PW, Fname, Lname FROM USERS WHERE User_email = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($useremail)));

        return $sth->fetchAll();
    }

    public function getEmail($email) {

        $sql = "SELECT User_email FROM USERS WHERE User_email = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email)));

        return $sth->fetchAll();
    }

    public function getDsn($email) {

        $sql = "SELECT USN FROM USERS WHERE User_email = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email)));

        return $sth->fetchAll();
    }

    public function getPassword($dsn) {

        $sql = "SELECT Hashed_PW FROM DOCTORS WHERE DSN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($dsn)));

        return $sth->fetchAll();
    }

    public function changePassword($dsn, $pwd) {

        $hashed = password_hash($pwd,PASSWORD_DEFAULT);

        $sql = "UPDATE DOCTORS SET Hashed_PW = ? WHERE DSN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($hashed),intval($dsn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function getUserdata($dsn) {

        $sql = "SELECT User_email, Fname, Lname, Gender, Birth, Phone FROM USERS WHERE USN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($dsn)));

        return $sth->fetchAll();
    }

    public function deleteID($dsn) {

        $sql = "DELETE FROM DOCTORS WHERE DSN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($dsn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function inputDir($dir) {
        $sql = "UPDATE DOCTORS SET Certificate_path = ? WHERE DSN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($dir),intval(22)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function fchangePassword($dsn, $pwd) {

        $hashed = password_hash($pwd,PASSWORD_DEFAULT);

        $sql = "UPDATE DOCTORS SET Hashed_PW = ? WHERE DSN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($hashed),strval($dsn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function updateDoctor($data, $dsn) {

        $sql = "UPDATE DOCTORS SET Fname = ?, Lname = ?, Birth = ?, Phone = ? WHERE DSN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($data->fname),strval($data->lname),strval($data->birth),strval($data->phone),intval($dsn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function getUserEmail($email) {

        $sql = "SELECT User_email FROM USERS WHERE User_email = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email)));

        return $sth->fetchAll();
    }

    public function getPatientdata($dsn) {

        $sql = "SELECT USN, U_email, U_Fname, U_Lname, U_Gender, U_Birth, U_Phone from COMPLETED_CONN where DSN = ?;";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($dsn)));

        return $sth->fetchAll();
    }*/

}