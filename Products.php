<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/fonts.css">
</head>

<body>
    <?php require_once 'header.php'; ?>
    <div class="container">
        <div class="form">
            <form action="" method="post">
                <select name="test">
			        <option value='Classic Cars'>Classic Cars</option>
			        <option value="Motorcycles">Motorcycles</option>
			        <option value="Planes">Planes</option>
			        <option value="Ships">Ships</option>
			        <option value="Trucks and Buses">Trucks and Buses</option>
			        <option value="Vintage Cars">Vintage Cars</option>
		        </select>
                <input class="button-submit" type="submit" value="submit">
            </form>
        </div>
        <?php
    	#connect to the database
    	try {
    		header('content-type:text/html;charset=utf-8');
			require_once 'dbconfig.php';
			$conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	} catch (PDOException $pe) {
		die ('Error! Could not access to $dbname :'. $pe->getMessage());
		}

		#read data from the database
		try {		
			if(isset($_POST['test'])){
                echo "<h1>".$_POST['test']."</h1>";
				echo "<table class='style-table'>";
				$temp = array('productCode','productName','productLine','productScale','productVendor','productDescription','quantityInStock','buyPrice','MSRP');
                echo "<tr>";
				for ($i = 0; $i < count($temp); $i++) {
					echo "<th class = 'style-th'>".$temp[$i].'</th>';
				}	
                echo "</tr>";
				$selected_val = $_POST['test']; 
				$sql = "SELECT * FROM products WHERE productLine='$selected_val'";
				$stmt = $conn->prepare($sql);
				$res = $stmt->execute();
				while ($row = $stmt->fetch()) {
					echo '<tr class = "style-tr">';
					for ($i = 0; $i < count($temp); $i++) {
                        if ($i != 5) {
                            echo '<td class="style-td">'.$row[$temp[$i]].'</td>';
                        }
                        else {
                            echo '<td class="style-td" style="text-align:left">'.$row[$temp[$i]].'</td>';
                        }
					}
				echo '</tr>';	
				}
				echo '</table>';
			}
		} catch (Exception $e) {
			die($e->getMessage());
		}	
	?>
    </div>
    <?php require_once 'footer.php' ?>
</body>


<script>
    f = document.getElementsByTagName('footer');
    f[0].className = 'footer-products';
</script>

</html>