<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produse</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/produsestyle.css">
</head>
<body>
    <div class="container">
        <div class="div_form">
            <nav>
                <a href="index.php">Main</a>
            </nav>
        <h3>Adaugare Produse</h3>
       
        
            <form id="insert_form" method="POST">
            <label for="nume">Nume:</label>
            <input type="text" id="nume_produs" name="nume_produs"><br><br>
            <label for="categorie">Categorie:</label>
            <input type="text" id="categorie" name="categorie"><br><br>
            <label for="Culoare">Culoare:</label>
            <input type="text" id="culoare" name="culoare"><br><br>
            <label for="stoc">Stoc: </label>
            <input type="number" name="stoc" id="stoc"><br><br>
            <input type="submit" value="Salvare">
            
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
            <form action="produse.php" method="post">
            <input type="submit" name="select_all" value="Select all data">
            </form>
            </div>
            <hr>

            <div class="delete_produse">
            <form id="delete_produse" method="GET">
            <label for="nume">Nume:</label>
             <input type="text" id="nume" name="nume"><br><br>
               <label for="id">ID:</label>
                <input type="text" id="id" name="id"><br><br>
             <input type="submit" value="Delete" >
            </form>
            <div id="message_delete"></div>
            </div>
            <hr>

             <div class="cautare_produse">
            <form id="search-form" method="get">
               <label for="id">ID:</label>
                <input type="text" id="id_produs" name="id_produs"><br><br>
             <input type="submit" value="Search" >
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
            $sql = "SELECT * FROM produse";
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
           
           
            // Close database connection
            oci_free_statement($stmt);
            oci_close($conn);
            ?>
            </div>

           

                <div class="count_div">
              <?php
              
                if ($count  == 0 ){

                } else {
                    echo "Sunt " . $count. " de produse.";
                    }
              ?>
                </div>
           
    </div>

      <script>
            $(document).ready(function() {
                $('#delete_produse').submit(function(event) {
                    event.preventDefault();

                    $.ajax({
                        type: 'GET',
                        url: 'delete_produse.php',
                        data: $('#delete_produse').serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#message_delete').text(response.message).removeClass('error').addClass('success');
                            } else {
                                $('#message_delete').text(response.message).removeClass('success').addClass('error');
                            }
                        },
                        error: function() {
                            $('#message_delete').text('An error occurred').removeClass('success').addClass('error');
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
                        url: 'insert_produse.php',
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
            .success { color: rgb(0, 5, 82); }
            .error { color: red; }
        </style>


     <script>
            const form = document.querySelector('#search-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // prevent the form from submitting normally
                const id = document.querySelector('#id_produs').value;
                const url = `cautare_produse.php?id_produs=${id}`;
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

</body>
</html>