<?php
//include connection file 
include "dbconnect.php";

// Fetch data from the database
$sql = "SELECT ItemID, ItemName, Brand, ItemDescription, Price FROM Items";
$result = $conn->query($sql);

// Output data in a table
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $itemID = htmlspecialchars($row["ItemID"], ENT_QUOTES, 'UTF-8');
        $itemName = htmlspecialchars($row["ItemName"], ENT_QUOTES, 'UTF-8');
        $brand = htmlspecialchars($row["Brand"], ENT_QUOTES, 'UTF-8');
        $itemDescription = htmlspecialchars($row["ItemDescription"], ENT_QUOTES, 'UTF-8');
        $price = number_format($row["Price"], 2);
        
        echo "<tr>
                <td>" . htmlspecialchars($row["ItemName"]) . "</td>
                <td>" . htmlspecialchars($row["Brand"]) . "</td>
                <td>" . htmlspecialchars($row["ItemDescription"]) . "</td>
                <td>$" . $price . "</td>
                <td><a href='javascript:void(0)' onclick=\"fneditItem('$itemID', '$itemName', 
                '$brand', '$itemDescription', '$price')\">Edit</a></td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No items found</td></tr>";
}

$conn->close();
?>
