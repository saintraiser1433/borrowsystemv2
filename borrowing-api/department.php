<?php
include 'header.php';
// Sample data (you can replace this with a database connection or any other data source)
$action = $_GET['action'];
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if ($action === 'GET') {
        $sql = "SELECT department_id,department_name,status FROM tbl_department order by department_id asc";
        $rs = $conn->query($sql);
        $data = [];

        if ($rs) {
            while ($row = $rs->fetch_assoc()) {
                // Assuming your resident table has 'id', 'name', and 'age' columns
                $data[] = [
                    'departmentId' => $row['department_id'],
                    'description' => $row['department_name'],
                    'status' => $row['status']
                ];
            }
        }
        echo json_encode($data);
    }
} else if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $description = $data['description'];
    $status = $data['status'];
    $query = "INSERT INTO tbl_department (department_name,status) 
    values ('$description',$status)";
    $stmt = $conn->query($query);
    if ($stmt) {
        echo json_encode(['message' => 'Department added successfully']);
    } else {
        echo json_encode(['error' => 'Failed to add Department']);
    }
} else if ($_SERVER["REQUEST_METHOD"] == 'PUT') {
    $description = $data['description'];
    $status = $data['status'];
    $departmentId = $data['departmentId'];

    $query = "UPDATE tbl_department SET 
        department_name='$description',
        status=$status
        where department_id=$departmentId";
    $stmt = $conn->query($query);
    if ($stmt) {
        echo json_encode(['message' => 'Department updated successfully']);
    } else {
        echo json_encode(['error' => 'Failed to update Department']);
    }
} else if ($_SERVER["REQUEST_METHOD"] == 'DELETE') {
    $departmentId = $_GET['departmentId'];
    $sqlDelete = "DELETE FROM tbl_department WHERE department_id = $departmentId";
    $result = $conn->query($sqlDelete);

    if ($result) {
        echo json_encode(['message' => 'Department deleted successfully']);
    } else {
        echo json_encode(['error' => 'Failed to delete Department']);
    }
}

