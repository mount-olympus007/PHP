<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Twilio\Rest\Client;


require 'vendor/autoload.php';


class apiController extends baseController
{
    public function Login($app)
    {
        $obj = array();
        $email = $app->get('GET.USER_NAME');
        $password = $app->get('GET.PASSWORD');
        $user = $this->userMapper->load(array('email=?', $email));
        if ($user != null && password_verify($password, password_hash($password, PASSWORD_DEFAULT))) {
            $obj[0] = [
                'user_id' => $user->Id,
                'stamp' => date("Y-m-d H:i:s")
            ];
            echo json_encode($obj);
        }
        else {
            $obj[0] = [
                'user_id' => 'Invalid Login Attempt',
                'stamp' => date("Y-m-d H:i:s")
            ];
            echo json_encode($obj);
        }
    }

    public function Logout($app){
        $mobile = $app->get('GET.mobile');
        $user = $this->userMapper->load(array('cell_phone=?', $mobile));
        $user->LoggedOut = 1;
        $user->save();
    }

    public function changeemail($app){
        $mobile = $app->get('GET.mobile');
        $user = $this->userMapper->load(array('cell_phone=?', $mobile));
        $pin = $this->generatePIN();
        $user->email_confirm_number = $pin;
        $user->save();
        $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
                $mail->isSMTP(); //Send using SMTP
                $mail->Host = 'smtp.sendgrid.net'; //Set the SMTP server to send through
                $mail->SMTPAuth = true; //Enable SMTP authentication
                $mail->Username = 'apikey'; //SMTP username
                $mail->Password = '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'; //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                $mail->Port = 465;

                $mail->setFrom('allen.bradford@intranetiq.com', 'WorkTodayUSA');
                $mail->addAddress($user->email, $user->first_name . " " . $user->last_name); //Add a recipient

                $mail->isHTML(true); //Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body = 'This is your confirmation code: <b>' . $pin . '</b>';
                $mail->AltBody = 'This is your confirmation code: ' . $pin;
                $mail->send();
                $obj[0] = [
                    'email_status' => "Sent!",
                    'stamp' => date("Y-m-d H:i:s")
                ];
                echo json_encode($obj);
            }
            catch (Exception $e) {
                $obj[0] = [
                    'mobile_status' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}",
                    'stamp' => date("Y-m-d H:i:s")
                ];
                echo json_encode($obj);
            }
    }

    public function register($app)
    {
        $pin = $this->generatePIN(6);

        $fn = $app->get('GET.FIRST_NAME');
        $ln = $app->get('GET.LAST_NAME');

        $cell = $app->get('GET.CELL');
        $email = $app->get('GET.USER_NAME');
        $pass = $app->get('GET.PASSWORD');

        $user = $this->userMapper->load(array('cell_phone=?', $cell));
        if ($user) {
            $user->mobile_confirm_number = $pin;
            $user->save();

            $sid = $app->get('TWILIO_ACCOUNT_SID');
            $token = $app->get('TWILIO_AUTH_TOKEN');
            $twilio = new Client($sid, $token);
            $this->f3->set("SESSION.mobile_pin", $pin);
            $this->f3->set("SESSION.mobile_phone", $cell);
            $message = $twilio->messages
                ->create("+14844777557", // to 
                array(
                "body" => "Your code is: " . $pin, "from" => "+19794014278"
            )
            );
            $obj = array();
            $obj[0] = [
                'user_id' => $user->Id,
                'stamp' => date("Y-m-d H:i:s")
            ];
            echo json_encode($obj);
        }
        else {
            $newUser = new ApplicationUser($this->GUID(), $fn, $ln, $cell, $email, $pass, "3123", "user");
            $dbUser = $this->userMapper;
            $dbUser->Id = $newUser->Id;
            $dbUser->first_name = $newUser->first_name;
            $dbUser->last_name = $newUser->last_name;
            $dbUser->branch_id = "3123";
            $dbUser->role = "user";
            $dbUser->cell_phone = $newUser->mobile;
            $dbUser->email = $newUser->email;
            $dbUser->password = password_hash($newUser->password, PASSWORD_DEFAULT);
            $dbUser->mobile_confirm_number = $pin;
            $dbUser->save();

            $sid = $app->get('TWILIO_ACCOUNT_SID');
            $token = $app->get('TWILIO_AUTH_TOKEN');
            $twilio = new Client($sid, $token);
            $this->f3->set("SESSION.mobile_pin", $pin);
            $this->f3->set("SESSION.mobile_phone", $cell);
            $message = $twilio->messages
                ->create("+14844777557", // to 
                array(
                "body" => "Your code is: " . $pin, "from" => "+19794014278"
            )
            );
            $obj = array();
            $obj[0] = [
                'user_id' => $dbUser->Id,
                'stamp' => date("Y-m-d H:i:s")
            ];
            echo json_encode($obj);
        }


    }

    public function confirmmobile($app)
    {
        $user = $this->userMapper->load(array('Id=?', $this->f3->get("GET.ID")));

        $obj = array();
        if ($user['mobile_confirm_number'] == $this->f3->get("GET.CODE")) {
            $user->mobile_confirmed = 1;
            $pin = $this->generatePIN(6);
            $user->email_confirm_number = $pin;
            $user->save();
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
                $mail->isSMTP(); //Send using SMTP
                $mail->Host = 'smtp.sendgrid.net'; //Set the SMTP server to send through
                $mail->SMTPAuth = true; //Enable SMTP authentication
                $mail->Username = 'apikey'; //SMTP username
                $mail->Password = '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'; //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                $mail->Port = 465;

                $mail->setFrom('allen.bradford@intranetiq.com', 'WorkTodayUSA');
                $mail->addAddress($user->email, $user->first_name . " " . $user->last_name); //Add a recipient

                $mail->isHTML(true); //Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body = 'This is your confirmation code: <b>' . $pin . '</b>';
                $mail->AltBody = 'This is your confirmation code: ' . $pin;
                $mail->send();
            }
            catch (Exception $e) {
                $obj[0] = [
                    'mobile_status' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}",
                    'stamp' => date("Y-m-d H:i:s")
                ];
                echo json_encode($obj);
            }

            $obj[0] = [
                'mobile_status' => "Verified!",
                'stamp' => date("Y-m-d H:i:s")
            ];
            echo json_encode($obj);

        }
        else {
            $obj[0] = [
                'mobile_status' => "Unverified",
                'stamp' => date("Y-m-d H:i:s")
            ];
            echo json_encode($obj);

        }
    }

    public function confirmemail($app)
    {
        $obj = array();
        $user = $this->userMapper->load(array('Id=?', $this->f3->get("GET.ID")));

        if ($user['email_confirm_number'] == $this->f3->get("GET.CODE")) {
            $user->email_confirmed = 1;
            $user->save();
            $obj[0] = [
                'email_status' => "Verified",
                'stamp' => date("Y-m-d H:i:s")
            ];
            echo json_encode($obj);
        }
        else {
            $obj[0] = [
                'email_status' => "Unverified",
                'stamp' => date("Y-m-d H:i:s")
            ];
            echo json_encode($obj);
        }
    }

    public function verifyBranchCode()
    {
        $branchId = $this->f3->get("GET.branch_code");
        $userId = $this->f3->get("GET.user_id");
        $user = $this->userMapper->load(array('Id=?', $userId));
        $user->branch_code = $branchId;
        $user->save();


    }

    public function GetWork($app)
    {
        $obj = array();
        $userId = $this->f3->get("GET.user_id");
        $user = $this->userMapper->load(array('Id=?', $userId));

        $listWork = $this->db->exec('SELECT * FROM workopportunities WHERE UserId=?', $userId);
        if ($user['branch_code'] == null || $user['branch_code'] == "") {
            $obj[0] = [
                'status' => "Confirmation Pending",
                'stamp' => date("Y-m-d H:i:s")
            ];

        }
        else {
            if (count($listWork) < 1) {

                $obj[0] = [
                    'status' => "No work opportunities available",
                    'stamp' => date("Y-m-d H:i:s")
                ];

            }
            else {
                $obj[0] = [
                    'status' => $listWork,
                    'stamp' => date("Y-m-d H:i:s")
                ];
            }
        }
        echo json_encode($obj);

    }

    public function GetChat($app)
    {
        $userId = $app->get('GET.UserId');
        $listChat = $this->db->exec("SELECT * FROM supportmessages WHERE UserId=?", $userId);
        $obj = array();
        if (count($listChat) < 1) {
            $user = $this->getuser();
            $username = $user['first_name'] + " " + $user['last_name'];
            $sid = getenv("TWILIO_ACCOUNT_SID");
            $token = getenv("TWILIO_AUTH_TOKEN");
            $twilio = new Client($sid, $token);
            $conversation = $twilio->conversations->v1->conversations
                ->create([
                "friendlyName" => $username + " Conversation"
            ]
            );
            $webhook = $twilio->conversations->v1->conversations($conversation->sid)
                ->webhooks
                ->create("webhook", // target
            [
                "configurationMethod" => "GET",
                "configurationFilters" => ["onMessageAdded", "onConversationRemoved"],
                "configurationUrl" => "http://10.0.2.2/flexapp/api/chathook"
            ]
            );
            $participant = $twilio->conversations->v1->conversations($conversation->sid)
                ->participants
                ->create([
                "messagingBindingAddress" => $user['mobile'],
                "messagingBindingProxyAddress" => "+19794014278"
            ]
            );
            $message = $twilio->conversations->v1->conversations($conversation->sid)
                ->messages
                ->create([
                "author" => "Admin",
                "body" => "Connected"
            ]
            );
            $obj[0] = [
                'conid' => $conversation->sid,
                'body' => $message,
                'author' => $username,
            ];
            echo json_encode($obj);
        }
        else {
            $obj[0] = [
                'conid' => $conversation->sid,
                'body' => $message,
                'author' => $username,
            ];
        }

        echo json_encode($listChat);
    }

    public function SendToSupport($app)
    {
        $userId = $app->get('GET.USER_ID');
        $brandId = $app->get('GET.BRANCH_ID');
        $message = $app->get('GET.MESSAGE');
        $timeStamp = date("Y-m-d H:i:s");
        $spId = $this->GUID();
        $user = $this->getuser();
        $username = $user['first_name'] + " " + $user['last_name'];


        $sid = getenv("TWILIO_ACCOUNT_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);
        $conversation = $twilio->conversations->v1->conversations
            ->create([
            "friendlyName" => $username + " Conversation"
        ]
        );
        $webhook = $twilio->conversations->v1->conversations($conversation->sid)
            ->webhooks
            ->create("webhook", // target
        [
            "configurationMethod" => "GET",
            "configurationFilters" => ["onMessageAdded", "onConversationRemoved"],
            "configurationUrl" => "http://10.0.2.2/flexapp/api/chathook"
        ]
        );
        $participant = $twilio->conversations->v1->conversations($conversation->sid)
            ->participants
            ->create([
            "messagingBindingAddress" => $user['mobile'],
            "messagingBindingProxyAddress" => "+19794014278"
        ]
        );
        $message = $twilio->conversations->v1->conversations($conversation->sid)
            ->messages
            ->create([
            "author" => $username,
            "body" => $message
        ]
        );
        $support_message = $this->db->exec("INSERT INTO supportmessages (Id, UserId, BranchId, Message, TimeStamp, Sender, ConversationId)
        VALUES (:Id, :UserId, :BranchId, :Message, :TimeStamp, :Sender, :ConversationId)",
            array(
            ':Id' => $spId,
            ':UserId' => $userId,
            ':BranchId' => $brandId,
            ':Message' => $message,
            ':TimeStamp' => $timeStamp,
            ':Sender' => $userId,
            ':ConversationId' => $conversation->sid

        ));
        $obj = array();

        $obj[0] = [
            'conid' => $conversation->sid,
            'body' => $message,
            'author' => $username,
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
    public function generatePIN($digits = 4)
    {
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while ($i < $digits) {
            //generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }
    public function getUser()
    {
        $mobile = $this->f3->get('GET.mobile');
        $user = $this->userMapper->load(array('cell_phone=?', $mobile));
        if ($user != null) {
            $obj[0] = [
                'id' => $user->Id,
                'email' => $user->email,
                'mobile' => $user->cell_phone,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'mobile_confirmed' => $user->mobile_confirmed,
                'email_confirmed' => $user->email_confirmed
            ];
            echo json_encode($obj);
        }
        else {

            $obj[0] = [
                'id' => 'Invalid Login Attempt',
                'email' => '',
                'password' => '',
                'mobile' => '',
            ];
            echo json_encode($obj);
        }
    }

    public function chathook()
    {

    }
}