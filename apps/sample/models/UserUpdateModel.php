<?php
namespace Sample\Model;


use Slimvc\Core\Model;

class UserUpdateModel extends Model
{
    public function changePassword($usn, $pwd) {

        $hashed = password_hash($pwd,PASSWORD_DEFAULT);

        $sql = "UPDATE USERS SET Hashed_PW = ? WHERE USN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($hashed),intval($usn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function deleteID($usn) {

        $sql = "DELETE FROM USERS WHERE USN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($usn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function fchangePassword($usn, $pwd) {

        $hashed = password_hash($pwd,PASSWORD_DEFAULT);

        $sql = "UPDATE USERS SET Hashed_PW = ? WHERE USN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($hashed),strval($usn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function updateDoctor($data, $dsn) {

        $sql = "UPDATE USERS SET Fname = ?, Lname = ?, Birth = ?, Phone = ? WHERE USN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($data->fname),strval($data->lname),strval($data->birth),strval($data->phone),intval($dsn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function updateUser($usn, $fname, $lname, $birth, $phone) {

        $sql = "UPDATE USERS SET Fname = ?, Lname = ?, Birth = ?, Phone = ? WHERE USN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($fname),strval($lname),strval($birth),strval($phone),intval($usn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function updateConnect($usn, $dsn) {

        $sql = "UPDATE CONN_and_req_info SET CONN_state = 1 WHERE requestingUSN = ? AND requestedUSN = ?";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($usn),intval($dsn)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function updateConnectRequest($usn, $dsn) {

        $sql = "INSERT into CONNECTION_U_and_D (requestingUSN, requestedUSN, Reg_date, CONN_State) VALUES (?, ?, ?, 0)";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($dsn),intval($usn),date("Y-m-d H:i:s")));

        return $this->getReadConnection()->lastInsertId();
    }
}