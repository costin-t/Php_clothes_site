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
            
        
        // Get the form data
        $data_comanda = $_POST["data_comanda"];
        $adresa_livrare = $_POST["adresa_livrare"];
        $id_client = $_POST["id_client"];
        $status_comanda = $_POST["status_comanda"];

        // Prepare an SQL statement to get the latest ID_COMANDA from the Comenzi table
        $sql = "SELECT id_comanda FROM Comenzi ORDER BY id_comanda DESC FETCH FIRST 1 ROWS ONLY";
        $stmt = oci_parse($conn, $sql);

        if (oci_execute($stmt)) {
            // Fetch the result
            $row = oci_fetch_assoc($stmt);

            // Store the value in a variable
            $latest_id_comanda = (int) $row['ID_COMANDA'];
        } else {
            $e = oci_error($stmt);
            echo "Error: " . htmlentities($e['message']);
        }
        
        
            
            
        // Prepare an SQL statement to insert data into the Comenzi table
        $sql = "INSERT INTO comenzi VALUES ($latest_id_comanda+1, TO_DATE(:data_comanda,'YYYY-MM-DD'), :adresa_livrare, :id_client, :status_comanda)";
        $stmt = oci_parse($conn, $sql);

        // Bind the form data to the prepared statement parameters
      
    
        oci_bind_by_name($stmt, ':data_comanda', $data_comanda);
        oci_bind_by_name($stmt, ':adresa_livrare', $adresa_livrare);
        oci_bind_by_name($stmt, ':id_client', $id_client);
        oci_bind_by_name($stmt, ':status_comanda', $status_comanda);

        // Execute the prepared statement
           if (oci_execute($stmt)) {
            $response = array('status' => 'success', 'message' => 'New record created successfully');
            } else {
                $e = oci_error($stmt);
                $response = array('status' => 'error', 'message' => htmlentities($e['message']));
            }

            // Close the prepared statement and database connection
            oci_free_statement($stmt);
            oci_close($conn);

            // Send the response as JSON
            header('Content-Type: application/json');
            echo json_encode($response);
            ?>
