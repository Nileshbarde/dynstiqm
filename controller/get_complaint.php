<?php
session_start();
// Include database connection
include 'db_connection.php';

$userid = $_SESSION['user_id'];
$roleid = $_SESSION['role_id']; // Assuming role_id is stored in session

// Fetch all complaints for the logged-in user
if($roleid == 2){
    $sql = "SELECT * FROM complaints WHERE user_id = $userid";
}
else {
    $sql = "SELECT * FROM complaints";

}
$result = $conn->query($sql);

$rows = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $buttons = '';
        if ($roleid == 1) {
            $buttons = "<button class='btn btn-sm btn-primary edit-complaint' data-id='{$row['id']}'>Edit</button>
                        <button class='btn btn-sm btn-secondary add-comment' data-id='{$row['id']}'>Comment</button>";
        }
        $rows .= "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['type']}</td>
                    <td>{$row['out_id']}</td>
                    <td>{$row['number']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['status']}</td>
                    <td>
                       $buttons
                    </td>
                  </tr>";
    }
} else {
    $rows = '<tr><td colspan="7">No complaints found.</td></tr>';
}

echo $rows;
$conn->close();
?>
