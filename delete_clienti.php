<?php
// Connection parameters
$host = 'localhost';
$port = '1521';
$dbname = 'orclpdb';
$username = 'angajat_app_haine';
$password = 'parola_angajat';

// Create connection
$conn = oci_connect($username, $password, "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SERVICE_NAME=$dbname)))");
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Get the ID of the client to be deleted from a form or URL parameter
$nume = $_GET['nume'];

// Prepare an SQL statement to delete a client by ID
$sql = "DELETE FROM clienti WHERE nume = :nume";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':nume', $nume);

// Execute the prepared statement
if (oci_execute($stmt)) {
    $response = array('status' => 'success', 'message' => 'Client deleted successfully');
} else {
    $e = oci_error($stmt);
    $response = array('status' => 'error', 'message' => 'Error: ' . htmlentities($e['message']));
}

// Close the prepared statement and database connection
oci_free_statement($stmt);
oci_close($conn);

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);