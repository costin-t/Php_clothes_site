<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport</title>
    <link rel="stylesheet" href="styles/style_transport.css">
</head>
<body>
    <div class="container">
        <div class="div_form">
            <nav>
                <a href="index.php">Main</a>
            </nav>
        <h3>Vizualizare Transport</h3>
       
        <form id="search-form" method="GET">
            <label for="id">ID:</label>
            <input type="number" id="id_transport" name="id_transport"><br><br>
            <input type="submit" name="select_transport" value="Verificare status">
            
        </form>


        
        </form>
        <div class="clear_button"> 
            <button onclick="clearOutput()" >Clear</button>
        </div>


        </div>

         <div class="select_all_transport">
            <form action="" method="post">
                <p>Verificare status toate comenzile</p>
            <input type="submit" name="select_all" value="Verificare status">
            </form>
            </div>

        <div id="result-div" class="result-div"> </div>
        <div class="select_query">
        
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

            // Execute SQL statement
            $sql = "SELECT *
            FROM transport t
            JOIN comenzi c ON t.ID_COMANDA = c.ID_COMANDA";
            $stmt = oci_parse($conn, $sql);
            oci_execute($stmt);

            $count = 0;
            
            // Fetch and output results
            if (isset($_POST['select_all'])) {
            while ($row = oci_fetch_array($stmt,OCI_ASSOC + OCI_RETURN_NULLS)) {
                foreach ($row as $item) {
                echo $item . ". ";
                }
                echo "<br>";
                
                $count++;

                 
                    
            }

             //echo "Sunt " . $count. " de clienti.";
        }
           
           
            // Close database connection
            oci_free_statement($stmt);
            oci_close($conn);
            ?>
            </div>

                <div class="count_div">
              <?php
              
                if ($count  == 0 ){

                } else {
                    echo "Sunt " . $count. " entitati";
                    }
              ?>


                
            </div>
            
            <script>
            const form = document.querySelector('#search-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // prevent the form from submitting normally
                const id = document.querySelector('#id_transport').value;
                const url = `cautare_transport.php?id_transport=${id}`;
                const xhr = new XMLHttpRequest(); // create an Ajax request
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // handle the response from the server
                        const resultDiv = document.querySelector('#result-div');
                        resultDiv.innerHTML = xhr.response;
                    }
                };
                xhr.open('GET', url, true); // send the request to the server
                xhr.send();
            });
        </script>

           
    </div>

    <script>
               function clearOutput() {
              var selectQueryDiv = document.querySelector('.select_query');
              if (selectQueryDiv) {
                selectQueryDiv.remove();
              }
                var selectQueryDiv = document.querySelector('.count_div');
              if (selectQueryDiv) {
                selectQueryDiv.remove();
              }
                var selectQueryDiv = document.querySelector('.result-div');
              if (selectQueryDiv) {
                selectQueryDiv.innerHTML = '<div id="result-div" class="result-div"> </div>';
              }
                }

            </script>

</body>
</html>