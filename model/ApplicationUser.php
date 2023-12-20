<?php

class ApplicationUser{
    public string $Id;
    public string $first_name;
    public string $last_name;
    public string $addressLine1;
    public string $city;
    public string $state;
    public string $zip;
    public string $mobile;
    public string $email;
    public string $password;
    public string $branch;
    public string $roles;


    public function __construct($Id, $first_name, $last_name, $mobile, $email, $password, $branch, $roles){
        $this->Id = $Id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->mobile = $mobile;
        $this->email = $email;
        $this->password = $password;
        $this->branch = $branch;
        $this->roles = $roles;
    }

    public function isInRole($roleName){
        
    }
    
}