<?php
session_start();
include_once 'php/DbConnection.php';
include_once 'php/validateEmail.php';
class Databases extends DbConnection
{
    public static $errors;
    public $con;
    public $order;
    public $search;
    public $domain = array();
    public $dom = array();
    public function __construct()
    {
        parent::__construct();
    }
    public function fetchdata($table_name, $order)
    {
        $search = ($this->search);
        if (empty($search)) {
            $query = "SELECT * FROM " . $table_name . " ORDER BY " . $order . "";
        } else {
            $query = "SELECT * FROM emails WHERE email LIKE '%$search%'";
        }
        $array = array();
        $result = mysqli_query($this->connection, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $array[] = $row;
        }
        return $array;
    }
    public function getDomainName()
    {
        foreach ($this->domain as $dn) {
            $parts = explode('@', $dn);
            $domainName = array_pop($parts);
            $filearr = explode(".", $domainName);
            $filewithoutextension = $filearr[0];
            array_push($this->dom, $filewithoutextension);
        }
        $this->dom = array_unique($this->dom);
    }
    public function insertdata($table_name, $data)
    {
        if (validate($data) === true) {
            $email = validate($data);
        } else {
            array_push($this->errors, validate($data));
        }
        if (isset($email)) {
            $query = "INSERT INTO emails (email) VALUES( '$data')";
            if (mysqli_query($this->connection, $query)) {
                return true;
            }
        } else {
            echo mysqli_error($this->connection);
        }
    }
    public function delete($where_condition)
    {
        $del = mysqli_query($this->connection, "delete from emails where id = '$where_condition'");
        if ($del) {
            return true;
        }
    }
}
session_unset();
session_destroy();
