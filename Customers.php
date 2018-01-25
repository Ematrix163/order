<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Index-Product line</title>
    <link rel=stylesheet type="text/css" href="./css/main.css">
</head>

<body>
    <?php require_once 'header.php'; ?>
    <div class="container">
        <?php
            /*Try to connect to the database*/
            header('content-type:text/html;charset=utf-8');
            require_once 'dbconfig.php';
            try {
                #connect to the database
                $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);  
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->exec("set names utf8");
            } catch (PDOException $pe) {
            die ("Error! Could not access to $dbname :". $pe->getMessage());
            } catch (Exceptin $e) {
                die($e->getMessage());
            }
            $sql_country = "SELECT DISTINCT country FROM customers ORDER BY country";
            $stmt_country = $conn->prepare($sql_country);
            $res_country = $stmt_country->execute();
        ?>
            <div class='sidebar'>
                <ul>
                    <?php while ($row = $stmt_country->fetch()): ?>
                    <li onclick="display(<?php $t = $row['country']; echo htmlspecialchars(" '".$t."' "); ?>)">
                        <?php echo htmlspecialchars("$t"); ?>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
            <div class="right-content">
                <div id='right'></div>
                <div id='more'></div>
            </div>

    </div>
    <?php require_once 'footer.php' ?>
    <script>
        var customers = [];
        <?php
            $sql_detail = "SELECT customerNumber, country, customerName name, phone, city, salesRepEmployeeNumber, creditLimit FROM customers";
            $stmt_d = $conn->prepare($sql_detail);
            $res_d = $stmt_d->execute();
            while ($row_d = $stmt_d->fetch()) {
                $cn = $row_d['customerNumber'];
                $c =  '"'.$row_d['country']. '"';
                $cl = '"'.$row_d['name'].'"';
                $p =  '"'.$row_d['phone'].'"';
                $city = '"'.$row_d['city'].'"';
                $sre = '"'.$row_d['salesRepEmployeeNumber'].'"';
                $crel = '"'.$row_d['creditLimit'].'"';
                echo "customers[$cn]=[$c,$cl,$city,$p,$sre,$crel];";
            }
        ?>

        function display(country) {
            var r = document.getElementById('right');
            var table = document.createElement('table');
            table.className = 'table-customers';
            var caption = document.createElement('caption');
            caption.appendChild(document.createTextNode(country));
            table.appendChild(caption);
            r.innerHTML = "";
            document.getElementById('more').innerHTML = '';
            var general = [];
            count = 0;
            /*Fetch the data of a given country*/
            var tr = document.createElement('tr');
            tr.innerHTML = "<th class = 'style-th'>Name</th><th class = 'style-th'>City</th>";
            table.appendChild(tr);
            for (x in customers) {
                if (customers[x][0] == country) {
                    general[count] = [customers[x][1], customers[x][2]];
                    count += 1;
                    var tr = document.createElement('tr');
                    var td = document.createElement('td');
                    tr.className = 'style-tr-click';
                    td.className = 'style-td-click';
                    td.appendChild(document.createTextNode(customers[x][1]));
                    tr.appendChild(td);
                    tr.setAttribute('onclick', 'detail(' + x + ')');
                    var td = document.createElement('td');
                    td.className = 'style-td-click';
                    td.appendChild(document.createTextNode(customers[x][2]));
                    tr.appendChild(td);
                    table.appendChild(tr);
                }

            }
            r.appendChild(table);
        }
        display('Australia');


        function detail(id) {
            var div = document.getElementById('more');
            div.innerHTML = '';
            var table = document.createElement('table');
            var caption = document.createElement('caption');
            caption.appendChild(document.createTextNode('Detail Information'));
            table.appendChild(caption);
            var temp = ['Customer Name: ', 'City: ', 'Phone Number:', 'Sales Rep: ', 'Credit Limit: '];
            for (i = 1; i <= 5; i++) {
                if (customers[id][i] != '') {
                    var tr = document.createElement('tr');
                    var td = document.createElement('td');
                    td.appendChild(document.createTextNode(temp[i - 1]));
                    tr.appendChild(td);
                    td = document.createElement('td');
                    td.appendChild(document.createTextNode(customers[id][i]));
                    tr.appendChild(td);
                    table.appendChild(tr);
                }
            }
            div.appendChild(table);
        }

        f = document.getElementsByTagName('footer');
        f[0].className = 'footer-customers';
    </script>

</body>

</html>