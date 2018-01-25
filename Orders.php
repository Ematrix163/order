<!DOCTYPE html>
<html>

<head>
    <title>Index-Product line</title>
    <link rel='stylesheet' type="text/css" href="./css/main.css">
    <link rel='stylesheet' type="text/css" href="./css/fonts.css">
</head>

<body>
    <?php require_once 'header.php'; ?>
    <div class="decoration">
        <h2>ORDERS</h2>
    </div>
    <div class="delay">
    <div class="container">
        <div class="inner">
            <?php
            try {
                $count = 0;
                /*Read the data from the database*/
                require_once 'dbconfig.php';
                $conn = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $pe) {
                die ('Error! Could not access to $dbname :'. $pe->getMessage());
                }

                $sql_pro = "SELECT * FROM orders WHERE status='In Process'";
                $sql_re = "SELECT * FROM orders ORDER BY orderDate DESC LIMIT 20";
                $stmt_pro = $conn->prepare($sql_pro);
                $stmt_re = $conn->prepare($sql_re);
                $res_pro = $stmt_pro->execute();
                $res_re = $stmt_re->execute();
                $temp = ['orderNumber','orderDate','status','customerNumber'];

                /*Table 1*/
                echo "<table class='style-table' style='width:100%'>";
                echo "<caption>All Orders in Process</caption>";
                echo "<tr>";
                /*Table Head*/
                for ($i = 0; $i <= 3; $i++) {
                    echo "<th class = 'style-th'>".$temp[$i]."</th>";
                }
                echo "</tr>";
                while ($row = $stmt_pro->fetch()) {
                    $count = $count + 1;
                    echo "<tr class='style-tr-click-tense' onclick = 'display_detail($count)'>";
                    for ($i = 0; $i <= 3; $i++) {
                        echo "<td class='style-td-tense'>".$row[$temp[$i]]."</td>";
                    }   
                    echo "</tr>";
                    echo "<tr><td colspan='4'>";
                    $n = $row['orderNumber'];
                    $sql_detail = "SELECT p.productCode, productLine, productName, comments FROM orders o, orderdetails od, products p WHERE o.orderNumber=od.ordernumber AND od.productCode = p.productCode AND o.orderNumber=$n";
                    $stmt_detail = $conn->prepare($sql_detail);
                    $res_detail = $stmt_detail->execute();
                    $detail_inf = ['productCode','productLine','productName','comments'];
                    /*Nested tables to display detail information when user click*/
                    echo "<table id=$count class='nested-table' style='display:none'><tr>";
                    for ($i = 0; $i <= 3; $i++) {
                            echo "<th>$detail_inf[$i]</th>";
                        } 
                    echo "</tr>";
                    while ($row_detail = $stmt_detail->fetch()) {
                        echo "<tr>";
                        for ($i = 0; $i <= 3; $i++) {
                            $s = $detail_inf[$i];
                            if ($row_detail[$s]!='') {
                                echo "<td>$row_detail[$s]</td>";
                            } else {
                                echo "<td>None</td>";
                            }
                        }
                        echo "</tr>";
                    }
                    echo "</table></td></tr>";
                }
                echo "</table>";
                
            
                echo "<div class='blank'></div>";
                /*Table 2*/
                echo "<table class='style-table' style='width:100%'>";
                echo "<caption>Recent 20 Orders</caption>";
                echo "<tr>";
                /*Table Head*/
                for ($i = 0; $i <= 3; $i++) {
                    echo "<th class = 'style-th'>".$temp[$i]."</th>";
                }
                echo "</tr>";
                while ($row = $stmt_re->fetch()) {
                    $count = $count + 1;
                    echo "<tr class='style-tr-click-tense' onclick = 'display_detail($count)'>";
                    for ($i = 0; $i <= 3; $i++) {
                        echo "<td class='style-td-tense'>".$row[$temp[$i]]."</td>";
                    }   
                    echo "</tr>";
                    echo "<tr><td colspan='4'>";
                    $n = $row['orderNumber'];
                    $sql_detail = "SELECT p.productCode, productLine, productName, comments FROM orders o, orderdetails od, products p WHERE o.orderNumber=od.ordernumber AND od.productCode = p.productCode AND o.orderNumber=$n";
                    $stmt_detail = $conn->prepare($sql_detail);
                    $res_detail = $stmt_detail->execute();
                    $detail_inf = ['productCode','productLine','productName','comments'];
                    /*Nested tables to display detail information when user click*/
                    echo "<table id=$count class='nested-table' style='display:none'><tr>";
                    for ($i = 0; $i <= 3; $i++) {
                            echo "<th>$detail_inf[$i]</th>";
                        } 
                    echo "</tr>";
                    while ($row_detail = $stmt_detail->fetch()) {
                        echo "<tr>";
                        for ($i = 0; $i <= 3; $i++) {
                            $s = $detail_inf[$i];
                            if ($row_detail[$s]!='') {
                                echo "<td>$row_detail[$s]</td>";
                            } else {
                                echo "<td>None</td>";
                            }
                        }
                        echo "</tr>";
                    }
                    echo "</table></td></tr>";
                }
                echo "</table>";
            ?>
        </div>
    </div>
    </div>
    <?php require_once 'footer.php' ?>
   <!-- <footer style="position:relative; top:50px"></footer>-->

    <script>
        function display_detail(id) {
            d = document.getElementById(id);
            if (d.style.display == 'none') {
                d.style.display = 'inline';
            } else {
                d.style.display = 'none';
            }
        }
    f = document.getElementsByTagName('footer');
    f[0].className = 'footer-orders';
    </script>
</body>


</html>