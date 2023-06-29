
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/style_comenzi.css">
    <title>Comenzi</title>
</head>
<body>
    <div class="container">
        <div class="div_form">
            <nav>
                <a href="index.php">Main</a>
            </nav>
        <h3>Adaugare Comenzi</h3>
       

    
        <form id="insert_form" method="post">
            
            <label for="data_comanda">Data comanda:</label>
            <input type="date" id="data_comanda" name="data_comanda"><br><br>
            
            <label for="adresa_livrare">Adresa livrare:</label>
            <input type="text" id="adresa_livrare" name="adresa_livrare"><br><br>
            
            <label for="id_client">ID client:</label>
            <input type="number" id="id_client" name="id_client"><br><br>
            
            <label for="status_comanda">Status comanda:</label>
            <input type="text" id="status_comanda" name="status_comanda"><br><br>
            
            <input type="submit" value="Submit">
            <hr>
        </form>

        <div id="message"></div>


        
        </form>
        <div class="clear_button"> 
            <button onclick="clearOutput()" >Clear</button>
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
        </div>


         <div class="select_all">
            <form action="" method="post">
            <input type="submit" name="select_all" value="Afisaza toate comenzile">
            </form>
            </div>

             <div class="delete_comenzi">
            <form id="delete_com" method="GET">
            <label for="nume">ID:</label>
             <input type="text" id="id_comanda" name="id_comanda" ><br><br>
             <input type="submit" value="Delete" >
            </form>
            <div id="message_delete"></div>
            </div>

            <div class="cautare_comenzi">
            
            <form id="search-form"  method="GET">
            <label for="nume">ID:</label>
             <input type="text" id="id_comanda_select" name="id_comanda_select"><br><br>
             <input type="submit" value="Search" >

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
            $sql = "SELECT * FROM comenzi";
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
        }

            oci_free_statement($stmt);
            oci_close($conn);
            ?>
            </div>

                <div class="count_div">
              <?php
              
                if ($count  == 0 ){

                } else {
                    echo "Sunt " . $count. " de comenzi.";
                    }
              ?>
  
            </div>

            <script>
            $(document).ready(function() {
                $('#delete_com').submit(function(event) {
                    event.preventDefault();

                    $.ajax({
                        type: 'GET',
                        url: 'delete_comenzi.php',
                        data: $('#id_comanda').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#message').text(response.message).removeClass('error').addClass('success');
                            } else {
                                $('#message').text(response.message).removeClass('success').addClass('error');
                            }
                        },
                        error: function() {
                            $('#message').text('An error occurred').removeClass('success').addClass('error');
                        }
                    });
                });
            });
        </script>

                 <script>
            $(document).ready(function() {
                $('#insert_form').submit(function(event) {
                    event.preventDefault();

                    $.ajax({
                        type: 'POST',
                        url: 'procesare_comenzi.php',
                        data: $('#insert_form').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#message').text(response.message).removeClass('error').addClass('success');
                            } else {
                                $('#message').text(response.message).removeClass('success').addClass('error');
                            }
                        },
                        error: function() {
                            $('#message').text('An error occurred').removeClass('success').addClass('error');
                        }
                    });
                });
            });

        </script>

        <style>
            .success { color: blue; }
            .error { color: red; }
        </style>
            
            <script>
            const form = document.querySelector('#search-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // prevent the form from submitting normally
                const id = document.querySelector('#id_comanda_select').value;
                const url = `cautare_comenzi.php?id_comanda_select=${id}`;
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

</body>
</html>