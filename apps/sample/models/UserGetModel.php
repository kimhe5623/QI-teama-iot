<?php
namespace Sample\Model;


use Slimvc\Core\Model;

class UserGetModel extends Model
{
    public function getDoctorAccount($useremail) {

        $sql = "SELECT USN, Hashed_PW FROM USERS WHERE User_email = ? and Who = 1";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($useremail)));

        return $sth->fetchAll();
    }

    public function getUserAccount($useremail, $who) {

        $sql = "SELECT USN, Hashed_PW, Fname, Lname FROM USERS WHERE User_email = ? and Who = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($useremail), intval($who)));

        return $sth->fetchAll();
    }

    public function getEmail($email) {

        $sql = "SELECT User_email FROM USERS WHERE User_email = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email)));

        return $sth->fetchAll();
    }

    public function getDsn($email) {

        $sql = "SELECT USN FROM USERS WHERE User_email = ? and Who = 1";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email)));

        return $sth->fetchAll();
    }

    public function getPassword($usn) {

        $sql = "SELECT Hashed_PW FROM USERS WHERE USN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($usn)));

        return $sth->fetchAll();
    }
    public function getUserdata($dsn) {

        $sql = "SELECT User_email, Fname, Lname, Gender, Birth, Phone FROM USERS WHERE USN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($dsn)));

        return $sth->fetchAll();
    }

    public function getUserEmail($email) {

        $sql = "SELECT User_email FROM USERS WHERE User_email = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email)));

        return $sth->fetchAll();
    }

    public function getDoctordata($dsn) {

        $sql = "SELECT DSN, D_email, D_Fname, D_Lname, D_Gender, D_Birth, D_Phone, requestingUSN, requestedUSN, CONN_state from CONN_and_req_info where USN = ?
                order by CONN_state desc, USN";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($dsn)));

        return $sth->fetchAll();
    }

    public function getPatientdata($dsn) {

        $sql = "SELECT USN, U_email, U_Fname, U_Lname, U_Gender, U_Birth, U_Phone, requestingUSN, requestedUSN, CONN_state from CONN_and_req_info where DSN = ?
                order by CONN_state desc, USN";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($dsn)));

        return $sth->fetchAll();
    }

    public function getDataApp($usn) {

        $sql = "SELECT User_email, Hashed_PW, Fname, Lname, Gender, Birth, Phone FROM USERS WHERE USN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($usn)));

        return $sth->fetchAll();
    }

    public function getUserEmailUsn($email) {

        $sql = "SELECT User_email, USN FROM USERS WHERE User_email = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email)));

        return $sth->fetchAll();
    }

    public function getDoctordatabyname($fname, $lname) {

        $sql = "SELECT USN, User_email, Fname, Lname, Birth, Gender from USERS where Fname = ? and Lname = ? and Who = 1";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($fname), strval($lname)));

        return $sth->fetchAll();
    }

    public function getDoctordatabyemail($email) {

        $sql = "SELECT USN, User_email, Fname, Lname, Birth, Gender from USERS where User_email = ? and Who = 1";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email)));

        return $sth->fetchAll();
    }

    public function getPatientdatabyname($fname, $lname) {

        $sql = "SELECT USN, User_email, Fname, Lname, Birth, Gender from USERS where Fname = ? and Lname = ? and Who = 0";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($fname), strval($lname)));

        return $sth->fetchAll();
    }

    public function getPatientdatabyemail($email) {

        $sql = "SELECT USN, User_email, Fname, Lname, Birth, Gender from USERS where User_email = ? and Who = 0";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($email)));

        return $sth->fetchAll();
    }

    public function getUserlist($who) {

        $sql = "SELECT USN, User_email, Fname, Lname, Birth, Gender from USERS where Who = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($who)));

        return $sth->fetchAll();
    }

    public function chkLicense($license) {

        $sql = "SELECT LicenseNUM from DOCTORS where LicenseNUM = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($license)));

        return $sth->fetchAll();
    }

    public function chkConnection($usn, $dsn) {

        $sql = "SELECT CSN from CONNECTION_U_and_D where (requestingUSN = ? AND requestedUSN = ?) OR (requestingUSN = ? AND requestedUSN = ?) ";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($usn),intval($dsn),intval($dsn),intval($usn)));

        return $sth->fetchAll();
    }

}