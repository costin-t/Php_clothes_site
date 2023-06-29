

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

            $nume_client = $_GET["nume_client"];
            // Execute SQL statement
            $sql = "SELECT * FROM clienti WHERE nume ='$nume_client'";
            $stmt = oci_parse($conn, $sql);
            oci_execute($stmt);

            
               $resultHTML = '';
                if ($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                    foreach($row as $name => $value) {
                         echo $name . ": " . $value . ". ";
                     }
                } else {
                    $resultHTML .= 'Numele clientului nu este gasit in baza de date';
                }

                // Send result back to client
                echo $resultHTML;

            
                        // Close database connection /*
            
            oci_free_statement($stmt);
            oci_close($conn);
            
     
            ?>
           
              

