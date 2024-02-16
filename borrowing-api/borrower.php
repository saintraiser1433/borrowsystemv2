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
    case 'PENDING':
        $sql = "SELECT 
        a.borrower_id,
        a.first_name,
        a.middle_name,
        a.last_name,
        CONCAT(a.last_name, ',', a.first_name, ',', LEFT(a.middle_name, 1)) AS full_name,
        a.phone_number,
        a.year_level,
        b.course_name,
        c.department_name,
        a.type,
        a.status,
        a.status_approval,
        a.docs_file,
        a.username,
        a.password
    FROM tbl_borrower a
    LEFT JOIN tbl_course b ON a.course_id = b.course_id
    LEFT JOIN tbl_department c ON a.department_id = c.department_id
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
                    'year_level' => $row['year_level'],
                    'department_name' => $row['department_name'],
                    'course_name' => $row['course_name'],
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
        break;

    case 'APPROVED':
        $sql = "SELECT 
        a.borrower_id,
        a.first_name,
        a.middle_name,
        a.last_name,
        CONCAT(a.last_name, ',', a.first_name, ',', LEFT(a.middle_name, 1)) AS full_name,
        a.phone_number,
        a.year_level,
        b.course_name,
        c.department_name,
        a.type,
        a.status,
        a.status_approval,
        a.docs_file,
        a.username,
        a.password
    FROM tbl_borrower a
    LEFT JOIN tbl_course b ON a.course_id = b.course_id
    LEFT JOIN tbl_department c ON a.department_id = c.department_id
    where (a.status = 0 OR a.status = 1) and a.status_approval=0
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
                    'year_level' => $row['year_level'],
                    'department_name' => $row['department_name'],
                    'course_name' => $row['course_name'],
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
        break;

    case 'PUT':
        $borrowerId = $_GET['borrowerId'];
        $query = "UPDATE tbl_borrower SET 
        status=1,
        status_approval=1
        where borrower_id='$borrowerId'";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Successfully Approved']);
        } else {
            echo json_encode(['error' => 'Failed to Approved']);
        }
        break;
    case 'DELETE':
        $borrowerId = $_GET['borrowerId'];
        $sqlDelete = "DELETE FROM tbl_borrower WHERE borrower_id = '$borrowerId'";
        $result = $conn->query($sqlDelete);

        if ($result) {
            echo json_encode(['message' => 'Borrower rejected successfully']);
        } else {
            echo json_encode(['error' => 'Failed to reject Borrower']);
        }
        break;
}
