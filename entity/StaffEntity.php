<?php

/**
 * Created by PhpStorm.
 * User: minhpn
 * Date: 17/07/2017
 * Time: 14:46
 */

namespace Entity;
class StaffEntity
{
    private $id;
    private $name;
    private $email;
    private $phone;

    public function __construct($arrayStaff = []) {
        $this
            ->setId(isset($arrayStaff['id']) ? $arrayStaff['id'] : null)
            ->setName(isset($arrayStaff['name']) ? $arrayStaff['name'] : '')
            ->setEmail(isset($arrayStaff['email']) ? $arrayStaff['email'] : '')
            ->setPhone(isset($arrayStaff['phone']) ? $arrayStaff['phone'] : '');
    }

//    public function handleUrl()
//    {
//        $url = explode('/', $_GET['controller']);
//        if (url[0]== "Staffs") {
//            $_GET['id'] = url[1];
//            return url[1];
//        } else {
//            echo "Unable to get id.";
//            return false;
//        }
//    }


    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
//        if (is_string($this->name) && !is_null($this->name))
        return $this->name;
    }

    public function setName($name) {
        $this->name= $name;
        return $this;
    }

    public function getEmail() {
//        if (is_string($this->email) && !is_null($this->name)) {
//            $this->email = filter_var($this->email, FILTER_VALIDATE_EMAIL);
        return $this->email;
//        }
    }

    public function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    public function getPhone() {
        //       if (is_string($this->phone) && !is_null($this->phone))
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }
}