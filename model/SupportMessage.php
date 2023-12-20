<?php

class SupportMessage{
    public string $Id;
    public string $UserId;
    public string $BranchId;
    public string $Message;
    public string $TimeStamp;
    public string $ConversationId;
    public function __construct($Id, $UserId, $BranchId,$Message,$TimeStamp,$ConversationId){
        $this->Id = $Id;
        $this->UserId = $UserId;
        $this->BranchId = $BranchId;
        $this->Message = $Message;
        $this->TimeStamp = $TimeStamp;
        $this->ConversationId = $ConversationId;
    }

}