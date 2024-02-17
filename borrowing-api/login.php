<?php
include 'header.php';


if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $fetch = json_decode($_POST['data'], true);
    $username = $fetch['username'];
    $password = $fetch['password'];
    $sql = "SELECT 
            type,
            CONCAT(last_name, ' ', first_name, ',', LEFT(middle_name, 1)) AS full_name
            FROM tbl_borrower where status=1 and status_approval=1 and username='$username' and password='$password'";
    $rs = $conn->query($sql);
    if ($rs->num_rows > 0) {
        $row = $rs->fetch_assoc();
        $details = array('username' => $row['full_name'], 'type' => $row['type'], 'status' => 1);
        echo json_encode($details);
    } else {
        $details = array('status' => 0, 'message' => 'Incorrect credentials');
        echo json_encode($details);
    }
}
