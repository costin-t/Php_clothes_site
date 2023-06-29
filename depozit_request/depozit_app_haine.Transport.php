
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depozit produse</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../styles/depozit_app_haine_view.css">
</head>
<body>
    <nav>
        <nav>
            <a href="../index.php">Main</a>
            <a href="../Depozit.php">Depozit</a>
        </nav>
    </nav>
    <div class="container">
        <h3>Depozit Transport</h3>

        <?php
            // Connection parameters
            $host = 'localhost';
            $port = '1521';
            $dbname = 'orclpdb';
            $username = 'depozit_app_haine';
            $password = 'parola_angajat';

            // Create connection
            $conn = oci_connect($username, $password, "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SERVICE_NAME=$dbname)))");

            // Check if connection was successful
            if (!$conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            // Execute SQL statement
            $sql = "SELECT * from depozit_app_haine.Transport";
            $stmt = oci_parse($conn, $sql);
            oci_execute($stmt);

            $count = 0;
            
           
             // Fetch and output results
            while ($row = oci_fetch_array($stmt, OCI_ASSOC + OCI_RETURN_NULLS)) {
                 foreach ($row as $name => $value) {
                echo $name . ": " . $value . ". ";
            }
                echo "<br>";
                $count++;
            }
            echo "<hr>";
            echo "<div id='client-count'>Sunt " . $count . " de comenzi</div>";
            
          
        ?>
      </div>
</body>
</html>