<?php
    function get_session_uname()
    {
        
    }

    class DBaccess
    {
        private $uname = '';

        public function __construct()
        {
            // find user with same session id
            $this->$uname = 'admin';
        }

        public function isValid()
        {
            return !empty($this->$uname);
        }

        function check_user($username, $password)
        {
            return true;
        }
    }
?>