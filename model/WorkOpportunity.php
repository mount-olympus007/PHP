<?php

class WorkOpportunity{
    public string $Id;
    public string $UserId;
    public string $NameOfBusiness;
    public string $Address;
    public string $City;
    public string $State;
    public string $Zip;
    public string $JobTitle;
    public float $Rate;
    public DateTime $StartTime;
    public DateTime $EndTime;
    public Status $CurrentStatus;

}

enum Status{
    case PendingAcceptance;
    case CurrentlyWorking;
}