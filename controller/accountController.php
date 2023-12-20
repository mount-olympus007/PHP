<?php

class accountController extends baseController{
    public function login() {
        //$this->db->exec("INSERT INTO roles(Id,RoleName)VALUES(:Id,:RoleName)",array(':Id' => $this->GUID(), ':RoleName' => 'user'));

        $user = $this->f3->get('SESSION.user_id');
        if($user){
            $this->f3->reroute('/home/dashboard');
        }
        echo Template::instance()->render("Login.html");
    }

    public function OnPostlogin(){
        $email = $this->f3->get('GET.email');
        $password = $this->f3->get('GET.password');
        $user = $this->userMapper->load(array('email=?', $email));
        if ($user != null && password_verify($password, $user->password)) {
            $this->f3->set('SESSION.user_id',$user->Id);
            if($user->role == "user"){
                $this->f3->reroute('/flexapp/home/dashboard');

            }
            else{
                $this->f3->reroute('/flexapp/admin/dashboard');
            }


        }
        else{
            $this->f3->set('SESSION.error', "Invalid Login Attempt");
            $this->f3->reroute('/');
        }


    }
    //endpoint for confirming email
    public function confirmEmail(){

    }

    //forgot password view, input email and send forgot password email
    public function forgotPassword(){

    }

    //endpoint for confirming password switch from sent email
    public function forgotPasswordConfirmation(){

    }

    //reset password view for valid logged-in user
    public function resetPassword(){

    }

    //endpoint for resetting password from sent email
    public function resetPasswordConfirmation(){

    }


    //Lockout page for too many bad login attempts
    public function lockout(){

    }

    public function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }
    
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),
    
            
    mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    
    }
    //Ish register method
    public function OnPostRegister($data){
        $password = password_hash($this->f3->get('POST.password'), PASSWORD_DEFAULT);
        $guid = $this->GUID();
        $user = $this->db->exec("INSERT INTO applicationusers (Id, first_name, last_name, address, city, state, zip, cell_phone, email, password, branch_id, role)
            VALUES (:Id, :first_name, :last_name, :address, :city, :state, :zip, :cell_phone, :email, :password, :branch_id, :role)",
            array(
                ':Id' => $guid,
                ':first_name' => $this->f3->get('POST.first_name'),
                ':last_name' => $this->f3->get('POST.last_name'),
                ':address' => $this->f3->get('POST.address'),
                ':city' => $this->f3->get('POST.city'),
                ':state' => $this->f3->get('POST.state'),
                ':zip' => $this->f3->get('POST.zip'),
                ':cell_phone' => $this->f3->get('POST.cell_phone'),
                ':email' => $this->f3->get('POST.email'),
                ':password' => $password,
                ':branch_id' => $this->f3->get('POST.branch_id'),
                ':role' => 'user'
            ));
            
            if($user) {
                $this->f3->set('SESSION.user_id',$guid);
                $support_message = $this->db->exec("INSERT INTO supportmessages (Id, UserId, BranchId, Message, TimeStamp, Sender)
                VALUES (:Id, :UserId, :BranchId, :Message, :TimeStamp, :Sender)",
                    array(
                    ':Id' => $this->GUID(),
                    ':UserId' => $guid,
                    ':BranchId' => $this->f3->get('POST.branch_id'),
                    ':Message' => "Welcome, feel free to send us a message",
                    ':TimeStamp' => date("Y-m-d H:i:s"),
                    ':Sender' => "07B17613-EF2A-4059-B063-372C085AC81E"
        
                ));

                $this->f3->reroute('/home/dashboard');

               // return true;
            } else {
                $this->f3->reroute('/account/register');

                //return false;
            }
    }

    public function register() {
        $body = json_decode($this->f3->get('BODY'), true);
        echo Template::instance()->render("register.html");

    }
}

