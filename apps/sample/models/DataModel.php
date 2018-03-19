<?php
namespace Sample\Model;


use Slimvc\Core\Model;

class DataModel extends Model
{
    public function insertAQIData($aqidata) {

        $sql = "INSERT into AQI_HISTORY (CO, SO2, NO2, O3, `PM2.5`, Temperature, USN, TS, LAT, LNG) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(floatval($aqidata->data->co), floatval($aqidata->data->so2), floatval($aqidata->data->no2), floatval($aqidata->data->o3), floatval($aqidata->data->pm2_5),
            floatval($aqidata->data->temperature), intval($aqidata->usn), strval($aqidata->timestamp), floatval($aqidata->location->lat), floatval($aqidata->location->lng) ));

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

    public function searchRealhrdata($usn) {

        $sql = "SELECT TS, Heart_rate, RR_rate, LAT, LNG from HEART_HISTORY where USN = ? order by TS desc limit 20";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($usn)));

        return $sth->fetchAll();
    }

    public function searchRealaqidata($usn) {

        $sql = "SELECT TS, CO, SO2, NO2, O3, `PM2.5`, Temperature, LAT, LNG from AQI_HISTORY where USN = ? order by TS desc limit 10";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($usn)));

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

        $sql = "SELECT TS, CO, SO2, NO2, O3, `PM2.5`, Temperature, LAT, LNG from AQI_HISTORY where TS >= ? and TS <= ? and USN = ? order by TS";

        $fdate.=' 00:00:00';
        $ldate.=' 24:00:00';

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(strval($fdate),strval($ldate),intval($usn)));

        return $sth->fetchAll();
    }

    public function insertHeartDataApp($usn, $ts, $lat, $lng, $heart, $rr) {

        $sql = "INSERT into HEART_HISTORY (Heart_rate, RR_rate, USN, TS, LAT, LNG) VALUES (?, ?, ?, ?, ?, ?)";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(floatval($heart), floatval($rr), intval($usn), strval($ts), floatval($lat), floatval($lng)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function insertAQIDataApp($usn, $ts, $lat, $lng, $co, $so2, $no2, $o3, $pm25, $tem) {

        $sql = "INSERT into AQI_HISTORY (CO, SO2, NO2, O3, `PM2.5`, Temperature, USN, TS, LAT, LNG) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(floatval($co), floatval($so2), floatval($no2), floatval($o3), floatval($pm25), floatval($tem), intval($usn), strval($ts), floatval($lat), floatval($lng)));

        return $this->getReadConnection()->lastInsertId();
    }

    public function getRealhrdata($usn) {

        $sql = "SELECT TS, Heart_rate, RR_rate, LAT, LNG from HEART_HISTORY where USN = ? order by TS desc limit 1";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($usn)));

        return $sth->fetchAll();
    }

    public function getRealaqidata($usn) {

        $sql = "SELECT TS, CO, SO2, NO2, O3, `PM2.5`, Temperature, LAT, LNG from AQI_HISTORY where USN = ? order by TS desc limit 1";

        $sth = $this->getReadConnection()->prepare($sql);
        $sth->execute(array(intval($usn)));

        return $sth->fetchAll();
    }
}
