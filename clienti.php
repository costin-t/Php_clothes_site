


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clienti</title>
    <link rel="stylesheet" href="styles/style_clienti.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="div_form">
            <nav>
                <a href="index.php">Main</a>
            </nav>
        <h3>Adaugare Clienti</h3>
       
        <form id="insert_form" method="post">
        <label for="nume">Nume:</label>

        <input type="text" id="insert_nume" name="insert_nume"><br><br>
        <label for="adresa">Adresa:</label>
        <input type="text" id="adresa" name="adresa"><br><br>
        <label for="telefon">Telefon:</label>
        <input type="text" id="telefon" name="telefon"><br><br>
        <input type="submit" value="Salvare">
    </form>
         <div id="message"></div>

        
        </form>
        <div class="clear_button"> 
            <button onclick="clearOutput()" >Clear</button>
        </div>

          
        
        </script>

        </div>

         <div class="select_all">
            <form action="" method="post">
            <input type="submit" name="select_all" value="Select all data">
            </form>
            </div>

             <div class="delete_forms_clienti">
            <form id="delete_clienti" method="GET">
            <label for="nume">Nume:</label>
             <input type="text" id="nume" name="nume"><br><br>
             <input type="submit" value="Delete" >
            </form>
            <div id="message_delete"></div>
            </div>

             <div class="cautare_clienti">
           
            <form  id="search-form" method="GET" form > 
            <label for="nume_client">Nume:</label>
             <input type="text" id="nume_client"  name="nume_client"><br><br>
             <input type="submit" value="Search" >
            </form>
            </div>



            <div id="result-div" class="result-div"> </div>


        <div class="select_query">
        <?php
            $host = 'localhost';
            $port = '1521';
            $dbname = 'orclpdb';
            $username = 'angajat_app_haine';
            $password = 'parola_angajat';
            $conn = oci_connect($username, $password, "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SERVICE_NAME=$dbname)))");
            if (!$conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            $sql = "SELECT * FROM clienti";
            $stmt = oci_parse($conn, $sql);
            oci_execute($stmt);
            $count = 0;
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
                    echo "Sunt " . $count. " de clienti.";
                    }
              ?>

            </div>
                 
    </div>

         <script>
            $(document).ready(function() {
                $('#delete_clienti').submit(function(event) {
                    event.preventDefault();

                    $.ajax({
                        type: 'GET',
                        url: 'delete_clienti.php',
                        data: $('#delete_clienti').serialize(),
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
                        url: 'insert_clienti.php',
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

 <script>
            const form = document.querySelector('#search-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // prevent the form from submitting normally
                const id = document.querySelector('#nume_client').value;
                const url = `cautare_clienti.php?nume_client=${id}`;
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