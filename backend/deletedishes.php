<?php
include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM dishes WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo "Xóa món ăn thành công";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("Location: index.php");
?>

