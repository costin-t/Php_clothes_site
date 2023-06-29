
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

            $insert_nume = $_POST["insert_nume"];
            $adresa = $_POST["adresa"];
            $telefon = $_POST["telefon"];


            $sql = "SELECT id_client FROM clienti ORDER BY id_client DESC FETCH FIRST 1 ROWS ONLY";
            $stmt = oci_parse($conn, $sql);

                if (oci_execute($stmt)) {
             // Fetch the result
                $row = oci_fetch_assoc($stmt);
            // Store the value in a variable
             $latest_id_clienti = (int) $row['ID_CLIENT'];
                } else {
            $e = oci_error($stmt);
            echo "Error: " . htmlentities($e['message']);
            }
            //$latest_id_clienti
            
            // Prepare an SQL statement to insert data into the table
            $sql = "INSERT INTO Clienti (id_client, Nume, Adresa, Telefon) VALUES ($latest_id_clienti+1, :insert_nume, :adresa, :telefon)";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ':insert_nume', $insert_nume);
            oci_bind_by_name($stmt, ':adresa', $adresa);
            oci_bind_by_name($stmt, ':telefon', $telefon);

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
