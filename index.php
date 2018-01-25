<?php
    require_once 'dbconfig.php';
    try {
        $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM productlines";
        $stmt = $conn->prepare($sql);
        $res = $stmt->execute();
    } catch (PDOException $pe) {
        die ('Error! Could not access to $dbname :'. $pe->getMessage());
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Index-Product line</title>
        <link rel='stylesheet' type="text/css" href="./css/main.css">
        <link rel='stylesheet' type="text/css" href="./css/fonts.css">
    </head>

    <body>
        <?php require_once 'header.php'; ?>
        <div class="container">
            <!--<div class="inner">-->
            <section>
                <div class="welcome">
                    <div class="introduction">
                        <h1>Welcome to Classic Models Company!</h1>
                        <p>Our company has mant products, including Classic Cars, Motorcycles, Planes, Ships, Trains, Trucks and Buses and Vintage Cars.</p>
                        <button class="button-view" onclick="window.scroll(0,734)">View the produclines</button>
                    </div>
                </div>
            </section>
            <section>
                <table class="style-table" style='position: relative; top: -16px;'>
                    <tr>
                        <th class="style-th">PRODUCTLINE</th>
                        <th class="style-th">TEXTDESCRIPTION</th>
                    </tr>
                    <?php while ($row = $stmt->fetch()):?>
                    <tr class="style-tr">
                        <td class="style-td"><img src="./image/<?php echo $row['productLine'] ?>.jpg">
                            <?php echo htmlspecialchars($row['productLine'])?>
                        </td>
                        <td class="style-td" style="text-align:left">
                            <?php echo htmlspecialchars($row['textDescription'])?>
                        </td>
                    </tr>
                    <?php endwhile;?>
                </table>
            </section>

        </div>
        <?php require_once 'footer.php' ?>
    </body>
    <script>
        f = document.getElementsByTagName('footer');
        f[0].className = 'footer-index';
    </script>

    </html>