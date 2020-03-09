<?php

session_start();

// initializing variables
$username = "";
$email    = "";
$isAdmin = 0;
$errors = array();
$products = "";
// connect to the database
$db = mysqli_connect('localhost', 'phpmyadmin', 'Alexander34', 'account');
mysqli_query($db, "SET NAMES UTF8");
/
    
// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) {
          array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
            array_push($errors, "The two passwords do not match");
    }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);
  
    if ($user) { // if user exists
        if ($user['username'] === $username) {
             array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }

  // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        $query = "INSERT INTO users (username, email, password, isAdmin) 
  			  VALUES('$username', '$email', '$password', 0)";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}





// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT isAdmin FROM users WHERE username='$username' AND password='$password' LIMIT 1";
        $results = mysqli_query($db, $query);
        // $isAdmin = "!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!"
        $isAdmin_get = mysqli_fetch_array($results);
        $isAdmin = $isAdmin_get['isAdmin'];
        $_SESSION['isAdmin'] = $isAdmin;

        if (mysqli_num_rows($results) == 1) {
      
      
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            header('location: index.php');
        } else {
        
            array_push($errors, "Wrong username/password combination");
        }
    }
}


//ADD FILM TO DATABASE

if (isset($_POST['film_add'])) {
    $film_name = mysqli_real_escape_string($db, $_POST['film_name']);
    $film_price = mysqli_real_escape_string($db, $_POST['film_price']);
    $film_description = mysqli_real_escape_string($db, $_POST['film_description']);
    $film_quantity = mysqli_real_escape_string($db, $_POST['film_quantity']);
    
    if (empty($film_name)) {
        array_push($errors, 'Введите имя фильма');
        
    }
    
    if (empty($film_price)) {
        array_push($errors, 'Введите цену');
        
    }
    
    if (empty($film_description)) {
        array_push($errors, 'Введите описание фильма');
        
    }
    
    if (empty($film_quantity)) {
        array_push($errors, 'Введите кол-во дисков на складе');
    }
    
    
    
    
    
    if (count($errors) == 0) {
        $query = "INSERT INTO products (name, description, quantity, price, created) 
  		VALUES('$film_name', '$film_description', '$film_quantity', '$film_price', now())";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
              $_SESSION['film_name'] = $film_name;
              $_SESSION['success'] = "Фильм был добавлен в базу данных";
              header('location: addProductsToDB.php');
        }
    }
}

//Retrieve products from database


    
## $products = mysql_query($db, "SELECT * FROM products WHERE id='1'");
