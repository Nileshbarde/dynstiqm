<?php
    // Include database connection
    include 'db_connection.php';

    // Fetch all complaints
    $sql = "SELECT * FROM complaints";
    $result = $conn->query($sql);

    $rows = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['type']}</td>
                        <td>{$row['out_id']}</td>
                        <td>{$row['number']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <button class='btn btn-sm btn-primary edit-complaint' data-id='{$row['id']}'>Edit</button>
                            <button class='btn btn-sm btn-secondary add-comment' data-id='{$row['id']}'>Comment</button>
                        </td>
                    </tr>";
        }
    } else {
        $rows = '<tr><td colspan="7">No complaints found.</td></tr>';
    }

    echo $rows;
    $conn->close();
?>
