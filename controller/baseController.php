<?php
class baseController {
    protected Base $f3;
    protected $db;
    protected $roleMapper;
    protected $userRoleMapper;
    protected $userMapper;
    protected $workMapper;
    protected $chatMapper;
    public function __construct()
    {
        $this->f3 = Base::instance();
        $this->db = new DB\SQL(
            'mysql:host=localhost;port=3306;dbname=flexapp',
            'allen.c.bradford@gmail.com',
            '9w!b5klLW]MB)@4Z'
        );
        $this->rolerMapper = new \DB\SQL\Mapper($this->db, 'roles');
        $this->userRoleMapper = new \DB\SQL\Mapper($this->db, 'userroles');
        $this->userMapper = new \DB\SQL\Mapper($this->db, 'applicationusers');
        $this->workMapper = new \DB\SQL\Mapper($this->db, 'workopportunities');
        $this->chatMapper = new \DB\SQL\Mapper($this->db, 'supportmessages');

    }
}