<?php
class Technician {
    private $technician_id, $first_name, $last_name, $email, $phone, $password;
    
    public function __construct(
            $first_name, $last_name, $email, $phone, $password) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone = $phone;
        $this->password = $password;
    }
    public function getFirstName() {
        return $this->first_name;
    }
    public function getLastName() {
        return $this->last_name;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getPhone() {
        return $this->phone;
    }
    public function getPassword() {
        return $this->password;
    }
}

?>