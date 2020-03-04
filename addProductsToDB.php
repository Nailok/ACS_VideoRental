<?php include('server.php') ?>
<!DOCTYPE html>
<meta charset="utf-8">
<html>
<head>
  <title>Добавить</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Добавить</h2>
  </div>

  <form method="post" action="addProductsToDB.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
        
  		<label>Название фильма</label>
  		<input type="text" name="film_name" >
  	</div>
  	<div class="input-group">
        <label>Описание фильма </label>
        <div>
  		<input type="text" name="film_description" contenteditable="true">
        </div>
  	</div>
    <div class="input-group">
        <label>Введите количество оставшихся дисков на складе</label>
  		<input type="number" name="film_quantity">
  	</div>
  	<div class="input-group">
        <label>Цена в рублях</label>
  		<input type="number" name="film_price">
  	</div>
    <div>
        <input type='file' name='file' />
        <input type='submit' value='Save name' name='but_upload'>  
    </div>
    <div class="input-group">
  		<button type="submit" class="btn" name="film_add">Добавить</button>
        <a type="submit" class="btn" onclick="window.location.href = 'index.php';">Вернуться</a>
    </div>    
  </form>
    
</body>
</html>