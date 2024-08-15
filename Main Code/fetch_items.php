<?php

//include connection file 
include "db_connect.php";

// Fetch data from the database
$sql = "SELECT PartID, PartName, PartDescription, Price FROM Parts";
$result = $conn->query($sql);

// Output data in a table
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $PartID = htmlspecialchars($row["PartID"], ENT_QUOTES, 'UTF-8');
        $PartName = htmlspecialchars($row["PartName"], ENT_QUOTES, 'UTF-8');
        $PartDescription = htmlspecialchars($row["PartDescription"], ENT_QUOTES, 'UTF-8');
        $price = number_format($row["Price"], 2);
        
        echo "<tr>
                <td>" . htmlspecialchars($row["PartName"]) . "</td>
                <td>" . htmlspecialchars($row["PartDescription"]) . "</td>
                <td>$" . $price . "</td>
                <td><a href='javascript:void(0)' onclick=\"fneditItem('$PartID', '$PartName', 
                 '$PartDescription', '$price')\">Edit</a></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No items found</td></tr>";
}

$conn->close();
?>
