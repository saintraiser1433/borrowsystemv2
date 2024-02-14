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
        $sql = "SELECT course_id,course_name,status FROM tbl_course order by course_id asc";
        $rs = $conn->query($sql);
        $data = [];

        if ($rs) {
            while ($row = $rs->fetch_assoc()) {
                // Assuming your resident table has 'id', 'name', and 'age' columns
                $data[] = [
                    'courseId' => $row['course_id'],
                    'description' => $row['course_name'],
                    'status' => $row['status']
                ];
            }
        }
        echo json_encode($data);
        break;
    case 'POST':
        $description = $data['description'];
        $status = $data['status'];
        $query = "INSERT INTO tbl_course (course_name,status) 
        values ('$description',$status)";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Course added successfully']);
        } else {
            echo json_encode(['error' => 'Failed to add Course']);
        }
        break;
    case 'PUT':
        $description = $data['description'];
        $status = $data['status'];
        $courseId = $data['courseId'];

        $query = "UPDATE tbl_course SET 
        course_name='$description',
        status=$status
        where course_id=$courseId";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Course updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update course']);
        }
        break;
    case 'DELETE':
        $courseId = $_GET['courseId'];
        $sqlDelete = "DELETE FROM tbl_course WHERE course_id = $courseId";
        $result = $conn->query($sqlDelete);

        if ($result) {
            echo json_encode(['message' => 'Course deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete course']);
        }
        break;
}
