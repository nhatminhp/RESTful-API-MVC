<?php
/**
 * Created by PhpStorm.
 * User: minhpn
 * Date: 17/07/2017
 * Time: 14:18
 */


namespace Controller;
use Model\StaffModel as StaffModel;
use View\StaffView as StaffView;
use Entity\StaffEntity as StaffEntity;




ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class StaffController
{
    private $_model;
    private $_view;


    public function __construct()
    {
        $this->_model = new StaffModel();
        $this->_view = new StaffView();
//        $this->process();
    }

    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function handleUrl() {
        $url = explode('/', $_GET['controller']);
        if ($url[0] == "staffs") {
            return $url[1];
        }
        return 0;
    }

    public function exportArray(StaffEntity $staff_e) {
        parse_str(file_get_contents("php://input"), $staffArray);
        $staff_e->setName($staffArray["name"]);
        $staff_e->setEmail($staffArray["email"]);
        $staff_e->setPhone($staffArray["phone"]);
    }

    public function convert(StaffEntity $staff_e) {
        $staffArray = array('id' => $staff_e->getId(),
                            'name' => $staff_e->getName(),
                            'email' => $staff_e->getEmail(),
                            'phone' => $staff_e->getPhone()
                            );
        return $staffArray;
    }

    public function get($type) {
        if (empty($this->handleUrl())) {
            if ($type == 'json')
                $this->_view->displayJson($this->_model->getAll());
            else $this->_view->displayXML($this->_model->getAll());
        } else {
            $toView = $this->_model->getStaffById($this->handleUrl());
            if ($type == 'json')
                $this->_view->displayJson($this->convert($toView));
            else $this->_view->displayXML($this->convert($toView));
        }
    }

    public function post($type) {
        $staff_e = new StaffEntity();
        $check = $this->_model->createStaff($staff_e);

        if ($check) {
            echo "Successfully Created";
            if ($type == 'json')
                $this->_view->displayJson($this->convert($staff_e));
            else $this->_view->displayXML($this->convert($staff_e));
        } else {
            echo "Failed to create.";
        }
    }

    public function put($type) {
        $staff_e = $this->_model->getStaffById($this->handleUrl());
        $check = $this->_model->updateStaff($staff_e);
        if ($check) {
            echo "Successfully updated.";
            if ($type == 'json')
                $this->_view->displayJson($this->convert($staff_e));
            else $this->_view->displayXML($this->convert($staff_e));
        } else {
            echo "Failed to update";
        }
    }

    public function delete() {
        $staff_e = $this->_model->getStaffById($this->handleUrl());
        $check = $this->_model->deleteStaff($staff_e);
        if ($check) {
            echo "Successfully deleted";
        } else {
            echo "Failed to delete";
        }
    }
}

