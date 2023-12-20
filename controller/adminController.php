<?php
require 'vendor/autoload.php'; 
use Twilio\Rest\Client; 
class adminController extends baseController
{
    public function index()
    {
        $userId = $this->f3->get('SESSION.user_id');
    
        $admin = $this->userMapper->load(array('Id=?', $userId));
        if($admin == false){

            $this->f3->reroute('/');

        }
        $users = $this->db->exec('SELECT * FROM applicationusers WHERE role!=?', 'admin');


        $userObjs = array();
        foreach ($users as $user) { 
            $userMessages = $this->db->exec('SELECT * FROM supportmessages WHERE UserId=?',$user['Id']);
           $newU = new userObject($user, $userMessages);
            array_push($userObjs,$newU);

        }
        $this->f3->set('userList', $userObjs);
        echo Template::instance()->render("AdminDash.html");

    }

    public function logout(){
        $userId = $this->f3->get('SESSION.user_id');
        $userId = $this->f3->set('SESSION.user_id', '');
        $this->f3->reroute('/');

    }
    public function chatroom(){
        $userId = $this->f3->get('GET.userId');
        $conversationId = $this->f3->get('GET.conversationId');

        $user =  $this->userMapper->load(array('Id=?', $userId));
        $userMessages = $this->db->exec('SELECT * FROM supportmessages WHERE UserId=? ORDER BY TimeStamp',$userId);
        if(count($userMessages) <1){
            $support_message = $this->db->exec("INSERT INTO supportmessages (Id, UserId, BranchId, Message, TimeStamp, Sender)
                VALUES (:Id, :UserId, :BranchId, :Message, :TimeStamp, :Sender)",
                    array(
                    ':Id' => $this->GUID(),
                    ':UserId' => $userId,
                    ':BranchId' => $user->branch_id,
                    ':Message' => "Welcome, feel free to send us a message",
                    ':TimeStamp' => date("Y-m-d H:i:s"),
                    ':Sender' => "07B17613-EF2A-4059-B063-372C085AC81E"
        
                ));
                array_push($userMessages,$support_message);
        }
        $this->f3->set('chatList', $userMessages);
        $this->f3->set('appUser', $user);
        $sid = getenv("TWILIO_ACCOUNT_SID");
$token = getenv("TWILIO_AUTH_TOKEN");
$twilio = new Client($sid, $token);

$participant = $twilio->conversations->v1->conversations($conversationId)
                                         ->participants
                                         ->create([
                                                      "identity" => "theAdmin"
                                                  ]
                                         );

        echo Template::instance()->render("ChatRoom.html");
    }

    public function sendtouser(){
        $userId = $this->f3->get('GET.userId');
        $message = $this->f3->get('GET.message');
        $spId = $this->GUID();
        $brandId = $this->f3->get('GET.branchId');
        $sender = $this->f3->get('SESSION.user_id');
        $timeStamp = date("Y-m-d H:i:s");


        $support_message = $this->db->exec("INSERT INTO supportmessages (Id, UserId, BranchId, Message, TimeStamp, Sender)
        VALUES (:Id, :UserId, :BranchId, :Message, :TimeStamp, :Sender)",
            array(
            ':Id' => $spId,
            ':UserId' => $userId,
            ':BranchId' => $brandId,
            ':Message' => $message,
            ':TimeStamp' => $timeStamp,
            ':Sender' => $sender

        ));
        $obj = array();

        $obj[0] = [
            'Id' => $spId,
            'UserId' => $userId,
            'BranchId' => $brandId,
            'Message' => $message,
            'TimeStamp' => $timeStamp,
            'Sender' => $userId
        ];
        echo json_encode($obj);


    }

    public function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535),


            mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));

    }

}

class userObject
{
    public $user;
    public $messages;
    public function __construct($user, $messages)
    {
        $this->user = $user;
        $this->messages = $messages;
    }
}