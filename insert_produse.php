
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

            $nume_produs = $_POST["nume_produs"];
            $categorie = $_POST["categorie"];
            $culoare = $_POST["culoare"];
            $stoc = $_POST["stoc"];

             

            $sql = "SELECT id_produs FROM produse ORDER BY id_produs DESC FETCH FIRST 1 ROWS ONLY";
            $stmt = oci_parse($conn, $sql);

                if (oci_execute($stmt)) {
             // Fetch the result
                $row = oci_fetch_assoc($stmt);
            // Store the value in a variable
             $latest_id = (int) $row['ID_PRODUS'];
                } else {
            $e = oci_error($stmt);
            echo "Error: " . htmlentities($e['message']);
            }
            
            
            // Prepare an SQL statement to insert data into the table
            $sql = "INSERT INTO produse VALUES ($latest_id+1, :nume_produs, :categorie, :culoare, :stoc)";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ':nume_produs', $nume_produs);
            oci_bind_by_name($stmt, ':categorie', $categorie);
            oci_bind_by_name($stmt, ':culoare', $culoare);
            oci_bind_by_name($stmt, ':stoc', $stoc);

          
            
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
