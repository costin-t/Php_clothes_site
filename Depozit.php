<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/depozitstyle.css">
    <title>Depozit</title>
</head>
<body> <div class="container">
        <div class="div_form">
            <nav>
                <a href="index.php">Main</a>
            </nav>
    <h3> Vizualizarea a bazei de date depozit  </h3>

    <form action="depozit_request/depozit_app_haine_clienti.php" method="GET">
        <input type="submit" name="depozit_app_haine" value="Vizualizarea depozit Clienti">
    </form>

     <form action="depozit_request/depozit_app_haine_produse.php" method="GET">
        <input type="submit" name="depozit_app_haine_produse" value="Vizualizarea depozit Produse">
    </form>

    <form action="depozit_request/depozit_app_haine.Comenzi.php" method="GET">
        <input type="submit" name="depozit_app_haine.Comenzi" value="Vizualizarea depozit Comenzi">
    </form>

    <form action="depozit_request/depozit_app_haine.Articol.php" method="GET">
        <input type="submit" name="depozit_app_haine.Articol" value="Vizualizarea depozit Articole">
    </form>

    <form action="depozit_request/depozit_app_haine.Plati.php" method="GET">
        <input type="submit" name="depozit_app_haine.Plati" value="Vizualizarea depozit Plati">
    </form>

      <form action="depozit_request/depozit_app_haine.Transport.php" method="GET">
        <input type="submit" name="depozit_app_haine.Transport" value="Vizualizarea depozit Transport">
    </form>

    <form action="depozit_request/depozit_app_haine.Recenzii.php" method="GET">
        <input type="submit" name="depozit_app_haine.Recenzii" value="Vizualizarea depozit Recenzii">
    </form>

</div>
</body>
</html>