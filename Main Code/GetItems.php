<?php

//include connection file 
include "ConnectDB.php";

// Get specfic columns from Parts table and execute the query on second line below
$sql = "SELECT PartID, PartName, Trademark, PartDescription, Price FROM Parts";
$result = $conn->query($sql);

// Check if there are any records returned from the query
if ($result->num_rows > 0) {
    // Using while loop for setting the data of each row
    while($row = $result->fetch_assoc()) {
        $PartID = htmlspecialchars($row["PartID"], ENT_QUOTES, 'UTF-8');
        $PartName = htmlspecialchars($row["PartName"], ENT_QUOTES, 'UTF-8');
        $trademark = htmlspecialchars($row["Trademark"], ENT_QUOTES, 'UTF-8');
        $PartDescription = htmlspecialchars($row["PartDescription"], ENT_QUOTES, 'UTF-8');
        $price = number_format($row["Price"], 2);
        
        echo "<tr>
                <td>" . htmlspecialchars($row["PartName"]) . "</td>
                <td>" . htmlspecialchars($row["Trademark"]) . "</td>
                <td>" . htmlspecialchars($row["PartDescription"]) . "</td>
                <td>$" . $price . "</td>
                <td><a href='javascript:void(0)' onclick=\"fneditItem('$PartID', '$PartName', '$trademark',
                 '$PartDescription', '$price')\">Edit</a></td>
              </tr>";
    }
} else {
    // Display No items found if no records returned from database
    echo "<tr><td colspan='4'>No items found</td></tr>";
}

$conn->close();
?>
