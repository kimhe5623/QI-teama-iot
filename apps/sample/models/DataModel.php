<?php
namespace Sample\Model;


use Slimvc\Core\Model;

class DataModel extends Model
{
    public function insertAQIData($aqidata) {

        $sql = "INSERT into AQI_HISTORY (CO, SO2, NO2, O3, `PM2.5`, Temperature, SSN, TS, LAT, LNG) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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

    public function getHeartdata($dsn) {

        $sql = "SELECT TS, Heart_rate from HEART_HISTORY where USN = ? order by TS";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($dsn)));

        return $sth->fetchAll();
    }

    public function searchHeartdata($usn, $fdate, $ldate) {

        $sql = "SELECT TS, Heart_rate, RR_rate, LAT, LNG from HEART_HISTORY where TS >= ? and TS <= ? and USN = ? order by TS";

        $fdate.=' 00:00:00';
        $ldate.=' 24:00:00';

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($fdate),strval($ldate),intval($usn)));

        return $sth->fetchAll();
    }

    public function searchRRdata($usn, $fdate, $ldate) {

        $sql = "SELECT TS, RR_rate from HEART_HISTORY where TS >= ? and TS <= ? and USN = ? order by TS";

        $fdate.=' 00:00:00';
        $ldate.=' 24:00:00';

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($fdate),strval($ldate),intval($usn)));

        return $sth->fetchAll();
    }

    public function searchAQIdata($usn, $fdate, $ldate) {

        $sql = "SELECT TS, CO, SO2, NO2, O3, `PM2.5`, Temperature from AQI_HISTORY where TS >= ? and TS <= ? and SSN = ? order by TS";

        $fdate.=' 00:00:00';
        $ldate.=' 24:00:00';

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($fdate),strval($ldate),intval($usn)));

        return $sth->fetchAll();
    }
}