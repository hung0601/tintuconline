<?php
class database
{
	//khai bao thuoc tinh

	private $conn = null;
	private $host = 'localhost';
	private $user = 'root';
	private $pass = '';
	private $data = 'tintuconline';
	private $result = null;

	//xay dung phuong thuc

	private function connect()
	{

		$this->conn = new mysqli($this->host, $this->user, $this->pass, $this->data)
			or die('Ket noi that bai');
		$this->conn->query('SET NAMES UTF8');
	}

	// Phuong thuc select du lieu

	public function select($sql)
	{
		$this->connect();
		$this->result = $this->conn->query($sql);
		//ket qua tra ve bien result 

	}
	function db_execute($sql)
	{
		$this->connect();
		return mysqli_query($this->conn, $sql);
	}
	function db_get_row($sql)
	{
		$this->connect();
		$result = mysqli_query($this->conn, $sql);
		$row = array();
		if (mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_assoc($result);
		}
		return $row;
	}
	function db_get_list($sql)
	{
		$this->connect();
		$data  = array();
		$result = mysqli_query($this->conn, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}
	function db_insert($table, $data = array())
	{
		// Hai biến danh sách fields và values
		$fields = '';
		$values = '';

		// Lặp mảng dữ liệu để nối chuỗi
		foreach ($data as $field => $value) {
			$fields .= $field . ',';
			$values .= "'" . addslashes($value) . "',";
		}

		// Xóa ký từ , ở cuối chuỗi
		$fields = trim($fields, ',');
		$values = trim($values, ',');

		// Tạo câu SQL
		$sql = "INSERT INTO {$table}($fields) VALUES ({$values})";

		// Thực hiện INSERT
		return $this->db_execute($sql);
	}

	public function fetch()
	{
		if ($this->result->num_rows > 0) {
			$rows = $this->result->fetch_assoc();
			// lay bien tra ve tro vao mang va dua toan bo vao rows

		} else {
			$rows = 0;
		}

		return $rows;
	}
	// PHUONG THUC CHUNG insert , update, delete;
	public function command($sql)
	{
		$this->connect();
		$this->conn->query($sql);
	}
}
