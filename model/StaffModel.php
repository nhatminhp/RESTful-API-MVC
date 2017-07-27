<?php
/**
 * Created by PhpStorm.
 * User: minhpn
 * Date: 17/07/2017
 * Time: 14:19
 */

namespace Model;

use Model\DBConfig as DBConfig;
use Entity\StaffEntity;
use Controller\StaffController;

class StaffModel
{
    private $dbh;

    public function __construct()
    {
        $this->dbh = self::Connect(new DBConfig());
    }

    public function __destruct()
    {

        $this->dbh = null;

    }

    static function Connect(DBConfig $dbConfig) {

        return new \PDO("mysql:host=" . $dbConfig->getServerName() . ";dbname=" . $dbConfig->getDatabase(), $dbConfig->getUserName(), $dbConfig->getPassword());

    }


    public function createStaff(StaffEntity $staff_e) {

        $ctrl = new StaffController();
        $ctrl->exportArray($staff_e);

        $name = $staff_e->getName();
        $email = $staff_e->getEmail();
        $phone = $staff_e->getPhone();

        $stmt = $this->dbh->prepare("INSERT INTO Staff (name,email,phone) VALUES(:name, :email,:phone)");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $bool = $stmt->execute();
        $staff_e->setId($this->dbh->lastInsertId());

        return $bool; // Return True or False

    }

    public function getStaffById($staffId) {

        $stmt = $this->dbh->prepare("SELECT * FROM Staff WHERE id = $staffId");
        $stmt->execute();
        return new StaffEntity($stmt->fetch(\PDO::FETCH_ASSOC));

    }

    public function updateStaff(StaffEntity $staff_e) {
        
        $ctrl = new StaffController();
        $ctrl->exportArray($staff_e);

        $id = $staff_e->getId();
        $name = $staff_e->getName();
        $email = $staff_e->getEmail();
        $phone = $staff_e->getPhone();

        $stmt = $this->dbh->prepare("UPDATE Staff SET name = '$name', email = '$email', phone = '$phone' WHERE id = $id ");
        return $stmt->execute();
    }

    public function deleteStaff(StaffEntity $staff_e) {

        $id = $staff_e->getId();
        $stmt = $this->dbh->prepare("DELETE FROM Staff WHERE id = $id");
        return $stmt->execute();

    }

    public function getAll() {

        $stmt = $this->dbh->prepare("SELECT * FROM Staff");
        $stmt->execute();

        $data = array();

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $data[]=$row;
        }
        return $data;

    }

}