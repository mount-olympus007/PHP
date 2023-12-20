<?php

class workcontroller extends baseController{
    public function dashboard(){
        echo Template::instance()->render("dashboard.html");

    }
}