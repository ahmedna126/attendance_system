<?php

    class Paginator extends db_conn{
        private $conn ;
        private $_limit ;
        private $_page ;
        private $_sql ;
        public $_total ;


            public function __construct($conn , $sql)
            {
                $this->conn = $conn;
                $this->_sql = $sql;

                $stmt = $this->conn->prepare($this->_sql);
                $stmt->execute();

                $this->_total = $stmt->rowCount();      
            }

            public function getData($limit = 10 , $page = 1){
                $this->_limit = $limit;
                $this->_page = $page;
                

                if (strcasecmp($this->_limit , "All") == 0){
                    $sql = $this->_sql; 
                }else{
                    $offset = ( ($this->_page - 1) * $this->_limit);

                    $sql = $this->_sql . " LIMIT " . $offset . " , {$this->_limit}";
                }
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();

                $results = array();

                while($row = $stmt->fetch()){
                    $results[] = $row;
                }

                $result = new stdClass();
                $result->page = $this->_page;
                $result->limit = $this->_limit;
                $result->total = $this->_total;
                $result->data = $results;

                return $result;
            }

            public function getAllRecords($sql)
            {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();                
                $totalRecords = $stmt->rowCount();
                return $totalRecords;
            }
            
            

    }


    