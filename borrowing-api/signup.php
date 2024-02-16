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
    case 'POST':
        $fetch = json_decode($_POST['data'], true);
        $borrowerId = $fetch['borrowerId'];
        $firstName = $fetch['firstName'];
        $middleName = $fetch['middleName'];
        $lastName = $fetch['lastName'];
        $phoneNumber = $fetch['phoneNumber'];
        $yearLevel = $fetch['yearLevel'];
        $courseId = $fetch['courseId'];
        $departmentId = $fetch['departmentId'];
        $type = $fetch['type'];
        $username = $fetch['username'];
        $password = $fetch['password'];
        $uploadsDir = 'uploads/';
        $pth = $uploadsDir . $fetch['docsFile'] . ".png";
        $dir = $fetch['docsFile'] . ".png";
        move_uploaded_file($_FILES['files']['tmp_name'], $pth);
        $query = "INSERT INTO tbl_borrower (
            borrower_id,
            first_name,
            middle_name,
            last_name,
            phone_number,
            year_level,
            course_id,
            department_id,
            type,
            status,
            status_approval,
            docs_file,
            username,
            password) 
        values (
            '$borrowerId',
            '$firstName',
            '$middleName',
            '$lastName',
            '$phoneNumber',
            '$yearLevel',
            $courseId,
            $departmentId,
            '$type',
            0,
            0,
            '$dir',
            '$username',
            '$password'
            )";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Successfully signup kindly wait for approval. We would message you thru text message for your status ']);
        } else {
            echo json_encode(['error' => 'Failed to signup']);
        }
        break;
}
