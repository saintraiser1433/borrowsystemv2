<?php
include 'header.php';
// Sample data (you can replace this with a database connection or any other data source)
$action = $_GET['action'];
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
} else if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $fetch = json_decode($_POST['data'], true);
    $borrowerId = $fetch['borrowerId'];
    $firstName = $fetch['firstName'];
    $middleName = $fetch['middleName'];
    $lastName = $fetch['lastName'];
    $phoneNumber = $fetch['phoneNumber'];
    $departmentId = $fetch['department'];
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
        echo json_encode(['error' => mysqli_error($conn)]);
    }
} else if ($_SERVER["REQUEST_METHOD"] == 'PUT') {
} else if ($_SERVER["REQUEST_METHOD"] == 'DELETE') {
}
