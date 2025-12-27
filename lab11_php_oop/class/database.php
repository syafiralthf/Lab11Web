<?php
class Database
{
    protected $conn;

    public function __construct()
    {
        global $config;

        $this->conn = new mysqli(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['db_name']
        );

        if ($this->conn->connect_error) {
            die("Koneksi Database gagal: " . $this->conn->connect_error);
        }
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    public function get($table, $where = null)
    {
        $sql = "SELECT * FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        $sql .= " LIMIT 1";

        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    public function fetchAll($sql)
    {
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function insert($table, $data)
    {
        $cols = implode(",", array_keys($data));
        $vals = array_map(fn($v) => "'" . $this->conn->real_escape_string($v) . "'", array_values($data));
        $vals = implode(",", $vals);

        return $this->conn->query("INSERT INTO $table ($cols) VALUES ($vals)");
    }

    public function update($table, $data, $where)
    {
        $set = [];
        foreach ($data as $k => $v) {
            $set[] = "$k='" . $this->conn->real_escape_string($v) . "'";
        }
        $set = implode(",", $set);

        return $this->conn->query("UPDATE $table SET $set WHERE $where");
    }

    public function delete($table, $where)
    {
        return $this->conn->query("DELETE FROM $table WHERE $where");
    }
}
