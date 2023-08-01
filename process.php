<?php
// Replace these with your actual database credentials
$host = "any";
$username = "any";
$password = "any";
$dbname = "any";

// Attempt to establish a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to insert data into the "tbl_cat" table
function insertDataIntblcat($conn, $data) {
    // Prepare the SQL query
    $sql = "INSERT INTO tbl_cat (title, img, status, cover_img) VALUES (?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);  
    
    // Bind parameters and execute the statement for each row of data
    foreach ($data as $row) {
        if ($row[0] !== 'id') {
            $stmt->bind_param("ssis", $row[3], $row[4], $row[11], $row[5]);
            $stmt->execute();
        }
    }
}



// Function to insert data into the "users" table
function insertDataIntblevent($conn, $data) {
    // Prepare the SQL query
    $sql = "INSERT INTO tbl_event (id,uid, cid,title,img ,cover_img ,sdate ,stime ,edate ,etime
    ,address ,status ,description ,disclaimer ,latitude ,longtitude ,is_booked ,event_status ,place_name) VALUES
    (?, ?, ?, ?, ?, ?, ?,? ,? ,? , ? , ? ,? ,? ,? ,? ,? ,? ,?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);  
    $i = 0;

    
    // Bind parameters and execute the statement for each row of data
    foreach ($data as $row) {
        if( $i !== 0)
        {
            $stmt->bind_param( "iiissssssssissssiss" ,$row[0], $row[1], $row[2], $row[3], $row[4], $row[5], $row[6]
            , $row[7], $row[30], $row[8], $row[9], $row[10], $row[11]
            , $row[12], $row[13], $row[14], $row[15], $row[16], $row[17]);
            $stmt->execute();    
        }
        $i = $i + 1; 

    }
}
// Function to insert data into the "tbl_type_price" table
function insertDataIntbltypeprice($conn, $data) {
    // Prepare the SQL query
    $sql = "INSERT INTO tbl_type_price (id, eid, type, price, tlimit, status, ticket_book) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = $conn->prepare($sql);  
    $i = 0;

    
    // Bind parameters and execute the statement for each row of data
    foreach ($data as $row) {
        if( $i !== 0)
        {
            $stmt->bind_param("iisiiii", $row[18], $row[19], $row[20], $row[21], $row[22], $row[23], $row[24]);
            $stmt->execute();    
        }
        $i = $i + 1; 

    }
}



// Get the JSON data sent from the client-side
$data = json_decode(file_get_contents('php://input'), true);

// Use the table name from the client-side (ignore "createCatTable", "createPriceTable", "createEventTable")
$tableName = $data['tableName'];
if ($tableName === 'tbl_cat') 
{
    $tableData = $data['tableData'];
    insertDataIntblcat($conn, $tableData);
} 
else if ($tableName === 'tbl_event')
{
    $tableData = $data['tableData'];
    insertDataIntblevent($conn, $tableData);
    
}
else if ($tableName === 'tbl_type_price')
{

    $tableData = $data['tableData'];
    insertDataIntbltypeprice($conn, $tableData);
    
}

// Don't forget to close the connection when you're done
$conn->close();
?>
