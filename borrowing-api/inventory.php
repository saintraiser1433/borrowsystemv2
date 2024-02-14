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
        $sql = "SELECT
        a.item_code,
        a.item_name,
        a.category_id,
        a.quantity,
        a.item_model,
        a.item_condition,
        a.status,
        a.description,
        a.img_path,
        b.category_name
    FROM
        tbl_inventory a 
    LEFT JOIN 
        tbl_categories b
    ON
        a.category_id = b.category_id
    ORDER BY a.category_id asc";
        $rs = $conn->query($sql);
        $data = [];

        if ($rs) {
            while ($row = $rs->fetch_assoc()) {
                $data[] = [
                    'asset_tag' => $row['item_code'],
                    'item_name' => $row['item_name'],
                    'category_id' => $row['category_id'],
                    'item_model' => $row['item_model'],
                    'quantity' => $row['quantity'],
                    'item_condition' => $row['item_condition'],
                    'status' => $row['status'],
                    'description' => $row['description'],
                    'img_path' => $row['img_path'],
                    'categoryName' => $row['category_name'],
                ];
            }
        }
        echo json_encode($data);
        break;

    case 'POST':
        $fetch = json_decode($_POST['data'], true);
        $asset_tag = $fetch['assetTag'];
        $item_name = $fetch['itemName'];
        $category_id = $fetch['categoryId'];
        $item_model = $fetch['itemModel'];
        $item_condition = $fetch['itemCondition'];
        $description = $fetch['description'];
        $status = $fetch['statusActive'];
        $uploadsDir = 'uploads/';
        if (empty($_FILES) || !isset($_FILES['files'])) {
            $dir = "NULL"; // Set to NULL keyword
        } else {
            $pth = $uploadsDir . $fetch['img_path'] . ".png";
            $dir = "'" . $fetch['img_path'] . ".png'";
            move_uploaded_file($_FILES['files']['tmp_name'], $pth);
        }
        $query = "INSERT INTO tbl_inventory (item_code,item_name,category_id,item_model,item_condition,description,img_path,status) 
        values ($asset_tag,'$item_name',$category_id,'$item_model','$item_condition','$description',$dir,$status)";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Asset added successfully']);
        } else {
            echo json_encode(['error' => 'Failed to add asset']);
        }
        break;
    case 'PUT':
        $fetch = json_decode($_POST['data'], true);
        $asset_tag = $fetch['assetTag'];
        $item_name = $fetch['itemName'];
        $category_id = $fetch['categoryId'];
        $item_model = $fetch['itemModel'];
        $item_condition = $fetch['itemCondition'];
        $description = $fetch['description'];
        $status = $fetch['statusActive'];
        $uploadsDir = 'uploads/';
        if (empty($_FILES) || !isset($_FILES['files'])) {
            $dir = "NULL"; // Set to NULL keyword
        } else {
            $pth = $uploadsDir . $fetch['img_path'] . ".png";
            $dir = "'" . $fetch['img_path'] . ".png'";
            move_uploaded_file($_FILES['files']['tmp_name'], $pth);
        }
        $query = "UPDATE tbl_inventory SET 
        item_name='$item_name',
        category_id=$category_id,
        item_model='$item_model',
        item_condition='$item_condition',
        description='$description',
        img_path=$dir,
        status=$status
        where item_code='$asset_tag'";
        $stmt = $conn->query($query);
        if ($stmt) {
            echo json_encode(['message' => 'Asset updated successfully']);
        } else {
            echo json_encode(['error' => 'Failed to update asset']);
        }
        break;
    case 'DELETE':
        $assettag = $_GET['asset_tag'];
        $sqlDelete = "DELETE FROM tbl_inventory WHERE item_code = '$assettag'";
        $result = $conn->query($sqlDelete);

        if ($result) {
            echo json_encode(['message' => 'Item deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete Item']);
        }
        break;
}
