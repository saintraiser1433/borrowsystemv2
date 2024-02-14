<?php
// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow these methods for the preflight request (OPTIONS)
header("Access-Control-Allow-Methods: GET, POST, OPTIONS,DELETE,PUT");

// Allow these headers for the preflight request (OPTIONS)
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
include 'conn.php';
// Sample data (you can replace this with a database connection or any other data source)
$action = $_GET['action'];
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);
switch ($action) {
    case 'GET':
        $sql = "SELECT department_id,description,status FROM tbl_department order by department_id asc";
        $rs = $conn->query($sql);
        $data = [];

        if ($rs) {
            while ($row = $rs->fetch_assoc()) {
                // Assuming your resident table has 'id', 'name', and 'age' columns
                $data[] = [
                    'departmentId' => $row['department_id'],
                    'description' => $row['description'],
                    'status' => $row['status']
                ];
            }
        }
        echo json_encode($data);
        break;
    case 'POST':
        $description = $data['description'];
        $status = $data['status'];
        $query = "INSERT INTO tbl_department (description,status) 
        values ('$description',$status)";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Department added successfully']);
        } else {
            echo json_encode(['error' => 'Failed to add Department']);
        }
        break;
    case 'PUT':
        $description = $data['description'];
        $status = $data['status'];
        $departmentId = $data['departmentId'];

        $query = "UPDATE tbl_department SET 
        description='$description',
        status=$status
        where department_id=$departmentId";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Department updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update Department']);
        }
        break;
    case 'DELETE':
        $departmentId = $_GET['departmentId'];
        $sqlDelete = "DELETE FROM tbl_department WHERE department_id = $departmentId";
        $result = $conn->query($sqlDelete);

        if ($result) {
            echo json_encode(['message' => 'Department deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete Department']);
        }
        break;
}
