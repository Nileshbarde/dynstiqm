<?php
    session_start();
    // Include database connection
    include 'db_connection.php';

    $userid = $_SESSION['user_id'];
    $roleid = $_SESSION['role_id']; // Assuming role_id is stored in session

    // // Fetch all complaints based on role
    // if($roleid == 2){
    //     $sql = "SELECT id, complaint_id, user_id, comment, status, created_at FROM complaint_comments";
    //     $stmt = $conn->prepare($sql);
    // } else {

    //     $sql = "SELECT id, complaint_id, user_id, comment, status, created_at FROM complaint_comments WHERE user_id = ?";
    //     $stmt = $conn->prepare($sql);
    //     $stmt->bind_param("i", $userid);
       
    // }

    // $stmt->execute();
    // $result = $stmt->get_result();

    // Fetch all complaints for the logged-in user
    if($roleid == 2){
        $sql = "SELECT * FROM complaint_comments WHERE user_id = $userid";
    }
    else {
        $sql = "SELECT * FROM complaint_comments";

    }
    $result = $conn->query($sql);

    $rows = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['complaint_id']}</td>
                        <td>{$row['user_id']}</td>
                        <td>{$row['comment']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['created_at']}</td>
                    </tr>";
        }
    } else {
        $rows = '<tr><td colspan="6">No comments found.</td></tr>';
    }

    echo $rows;
    $conn->close();
?>
