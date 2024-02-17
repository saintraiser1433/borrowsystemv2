<?php
// Allow requests from any origin
include 'header.php';
// Sample data (you can replace this with a database connection or any other data source)
$action = $_GET['action'];

$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if ($action == 'PENDING') {
        $sql = "SELECT 
        a.borrower_id,
        a.first_name,
        a.middle_name,
        a.last_name,
        CONCAT(a.last_name, ' ', a.first_name, ',', LEFT(a.middle_name, 1)) AS full_name,
        a.phone_number,
        b.department_name,
        a.type,
        a.status,
        a.status_approval,
        a.docs_file,
        a.username,
        a.password
    FROM tbl_borrower a
    LEFT JOIN tbl_department b ON a.department_id = b.department_id
    where a.status = 0 and a.status_approval=0
    ORDER BY a.date_created ASC;
    ";
        $rs = $conn->query($sql);
        $data = [];

        if ($rs) {
            while ($row = $rs->fetch_assoc()) {
                // Assuming your resident table has 'id', 'name', and 'age' columns
                $data[] = [
                    'borrower_id' => $row['borrower_id'],
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'last_name' => $row['last_name'],
                    'full_name' => $row['full_name'],
                    'phone_number' => $row['phone_number'],
                    'department_name' => $row['department_name'],
                    'type' => $row['type'],
                    'status' => $row['status'],
                    'status_approval' => $row['status_approval'],
                    'docs_file' => $row['docs_file'],
                    'username' => $row['username'],
                    'password' => $row['password'],
                ];
            }
        }
        echo json_encode($data);
    } else {
        $sql = "SELECT 
        a.borrower_id,
        a.first_name,
        a.middle_name,
        a.last_name,
        CONCAT(a.last_name, ' ', a.first_name, ',', LEFT(a.middle_name, 1)) AS full_name,
        a.phone_number,
        b.department_name,
        a.type,
        a.status,
        a.status_approval,
        a.docs_file,
        a.username,
        a.password
    FROM tbl_borrower a
    LEFT JOIN tbl_department b ON a.department_id = b.department_id
    where (a.status = 0 OR a.status = 1) and a.status_approval=1
    ORDER BY a.date_created ASC
    ";
        $rs = $conn->query($sql);
        $data = [];

        if ($rs) {
            while ($row = $rs->fetch_assoc()) {
                // Assuming your resident table has 'id', 'name', and 'age' columns
                $data[] = [
                    'borrower_id' => $row['borrower_id'],
                    'first_name' => $row['first_name'],
                    'middle_name' => $row['middle_name'],
                    'last_name' => $row['last_name'],
                    'full_name' => $row['full_name'],
                    'phone_number' => $row['phone_number'],
                    'department_name' => $row['department_name'],
                    'type' => $row['type'],
                    'status' => $row['status'],
                    'status_approval' => $row['status_approval'],
                    'docs_file' => $row['docs_file'],
                    'username' => $row['username'],
                    'password' => $row['password'],
                ];
            }
        }
        echo json_encode($data);
    }
} else if ($_SERVER["REQUEST_METHOD"] == 'PUT') {
    if($action === 'PUT'){
            $borrowerId = $_GET['borrowerId'];
            $query = "UPDATE tbl_borrower SET 
            status=1,
            status_approval=1
            where borrower_id='$borrowerId'";
            $stmt = $conn->query($query);
            if ($stmt) {
                echo json_encode(['message' => 'Successfully Approved']);
            } else {
                echo json_encode(['error' => mysqli_error($conn)]);
            }
      
    }
} else if ($_SERVER["REQUEST_METHOD"] == 'DELETE') {
    if($action === 'DELETE'){
        $borrowerId = $_GET['borrowerId'];
        $sqlDelete = "DELETE FROM tbl_borrower WHERE borrower_id = '$borrowerId'";
        $result = $conn->query($sqlDelete);
        if ($result) {
            echo json_encode(['message' => 'Borrower rejected successfully']);
        } else {
            echo json_encode(['error' => mysqli_error($conn)]);
        }
    }
 

}
