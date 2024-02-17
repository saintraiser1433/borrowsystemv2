<?php
include 'header.php';
// Sample data (you can replace this with a database connection or any other data source)
$action = $_GET['action'];
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);
if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if ($action === 'GET') {
        $sql = "SELECT category_id,category_name,status FROM tbl_categories order by category_id asc";
        $rs = $conn->query($sql);
        $data = [];

        if ($rs) {
            while ($row = $rs->fetch_assoc()) {
                // Assuming your resident table has 'id', 'name', and 'age' columns
                $data[] = [
                    'categoryId' => $row['category_id'],
                    'description' => $row['category_name'],
                    'status' => $row['status']
                ];
            }
        }
        echo json_encode($data);
    }
} else if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    if ($action === 'POST') {
        $description = $data['description'];
        $status = $data['status'];
        $query = "INSERT INTO tbl_categories (category_name,status) 
        values ('$description',$status)";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Category added successfully']);
        } else {
            echo json_encode(['error' =>  mysqli_error($conn)]);
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == 'PUT') {
    if ($action === 'PUT') {
        $description = $data['description'];
        $status = $data['status'];
        $categoryId = $data['categoryId'];

        $query = "UPDATE tbl_categories SET 
        category_name='$description',
        status=$status
        where category_id=$categoryId";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Category updated successfully']);
        } else {
            echo json_encode(['error' =>  mysqli_error($conn)]);
        }
    }
} else if ($_SERVER["REQUEST_METHOD"] == 'DELETE') {
    $categoryId = $_GET['categoryId'];
    $sqlDelete = "DELETE FROM tbl_categories WHERE category_id = $categoryId";
    $result = $conn->query($sqlDelete);

    if ($result) {
        echo json_encode(['message' => 'Category deleted successfully']);
    } else {
        echo json_encode(['error' =>  mysqli_error($conn)]);
    }
}
