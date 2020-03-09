<?php
    session_start();

    $db = mysqli_connect('localhost', 'phpmyadmin', 'Alexander34', 'account');
mysqli_query($db, "SET NAMES UTF8");
    $query = "SELECT * FROM products ORDER BY id ASC";
    $product_array = mysqli_query($db, $query);
if (!empty($product_array)) { 
	foreach($product_array as $key=>$value){
?>
	<div class="product-item">
		<form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["id"]; ?>">
		<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
		<div class="product-tile-footer">
		<div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
        <div class="product-title"><?php echo $product_array[$key]["quantity"]; ?></div>
		<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
		</div>
		</form>
	</div>
<?php
	}
}
?>