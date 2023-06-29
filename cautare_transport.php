
        <?php
            // Connection parameters
            $host = 'localhost';
            $port = '1521';
            $dbname = 'orclpdb';
            $username = 'angajat_app_haine';
            $password = 'parola_angajat';

            // Create connection
            $conn = oci_connect($username, $password, "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SERVICE_NAME=$dbname)))");

            // Check if connection was successful
            if (!$conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            $id_transport = $_GET["id_transport"];
            // Execute SQL statement
            $sql = "SELECT t.ID_TRANSPORT, t.DATA_TRANSPORT, t.ADRESA_LIVRARE, t.ID_COMANDA, t.STATUS_TRANSPORT, c.* 
                FROM transport t
                JOIN comenzi c ON t.ID_COMANDA = c.ID_COMANDA
                WHERE t.ID_TRANSPORT = '$id_transport'";
            $stmt = oci_parse($conn, $sql);
            oci_execute($stmt);

            
               $resultHTML = '';
                if ($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    $resultHTML .= '<ul>';
                   foreach($row as $name => $value) {
                         echo $name . ": " . $value . ". ";
                     }
                } else {
                    $resultHTML .= 'Numele transportului nu este gasit in baza de date';
                }

                // Send result back to client
                echo $resultHTML;


            
                        // Close database connection
            oci_free_statement($stmt);
            oci_close($conn);
     
            ?>
           
              

