<?php
    class dbaccess_mysqli
    {
        private $conn = null;
        private $table_prefix = '';

        public function __construct($host, $user, $pass, $name, $prefix)
        {
            $this->conn = new mysqli($host, $user, $pass, $name);
            $this->table_prefix = $prefix;
        }

        public function isValid()
        {
            return !empty($this->conn);
        }

        public function query($sqli)
        {
            return $this->conn->query($sqli);
        }

        public function get_error()
        {
            return $this->conn->error;
        }

        public function check_table($table_name)
        {
            /*$sql = "SELECT * 
                    FROM information_schema.tables
                    WHERE table_schema = '$table_name' 
                        AND table_name = '$dbname'
                    LIMIT 1";

            $result = $this->conn->query($sql);

            if ($result->num_rows > 0)
                while($row = $result->fetch_assoc()) {
                    //foreach ($row as $val)
                        if ( strcasecmp($row["uname"], $uname)==0 )
                            return true;
                }*/
            $sql = "SHOW TABLES LIKE '{$this->table_prefix}{$table_name}'";

            $result = $this->query($sql);

            if ($result->num_rows > 0)
                return true;

            return false;
        }

        public function uname_exists($uname)
        {
            $sql = "SELECT uname
                    FROM {$this->table_prefix}user_data
                    WHERE uname='$uname'";

            $result = $this->query($sql);

            if ($result->num_rows > 0)
                return true;
                /*while($row = $result->fetch_assoc()) {
                    //foreach ($row as $val)
                        if ( strcasecmp($row["uname"], $uname)==0 )
                            return true;
                }*/

            return false;
        }

        public function check_user($uname, $pass)
        {
            $sql = "SELECT pass
                    FROM {$this->table_prefix}user_data
                    WHERE uname='$uname'";
            $result = $this->query($sql);

            if ($result->num_rows > 0)
                while($row = $result->fetch_assoc()) {
                    //foreach ($row as $val)
                    //if ( strcasecmp($row["pass"], $uname)==0 )
                    if ( password_verify($pass, $row["pass"]))
                        return true;
                }

            return false;
        }

        public function do_login($uname, $sess_id)
        {
            $sql = "UPDATE {$this->table_prefix}user_data
                    SET login='$sess_id'
                    WHERE uname='$uname'";

            return $this->query($sql);
        }


        public function login($uname, $pass, $sess_id)
        {
            return $this->check_user($uname, $pass) &&
                $this->do_login($uname, $sess_id);

            // put session id in db
            /*$sql = "UPDATE {$this->table_prefix}user_data
                    SET login={$sess_id}
                    WHERE uname={$uname}";

            return $this->query($sql);*/
        }

        public function logout($uname)
        {
            $sql = "UPDATE {$this->table_prefix}user_data
                    SET login=''
                    WHERE uname='$uname'";
            return $this->query($sql);
        }

        public function check_login($sess_id)
        {
            $sql = "SELECT uname
                    FROM {$this->table_prefix}user_data
                    WHERE login='$sess_id'";
            $result = $this->query($sql);
            
            if ($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                return $row["uname"];
            }

            return "";
        }

        public function add_user($fname, $lname, $gender, $uname, $pass, $type)
        {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO {$this->table_prefix}user_data
                        (fname, lname, gender, uname, pass, type)
				    VALUES ('$fname', '$lname', '$gender', '$uname', '$pass', '$type')";
            /*if ($this->conn->query($sql) === TRUE)
                echo "New record created successfully";
            else
                echo "Error: " . $sql . "<br>" . $this->conn->error;*/
            return $this->query($sql);
        }

        public function change_password($uname, $pass)
        {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "UPDATE {$this->table_prefix}user_data
                    SET pass={$pass}
                    WHERE uname='$uname'";
            return $this->query($sql);
        }

        public function add_quiz($quiz)
        {
            $title = $this->conn->escape_string($quiz['title']);
            $sql = "INSERT INTO {$this->table_prefix}quiz_data
                        (title)
                    VALUES ('$title')";
            $ret = $this->query($sql);
            if (!$ret)
                return false;



            return true;
        }

        public function list_quizzes()
        {
            
        }

        public function get_tags($sort)
        {
            "SELECT * ";
        }
    }
?>