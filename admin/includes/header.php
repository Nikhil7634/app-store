<?php

// Fetch admin username from the database
$adminName = "Admin"; // Default fallback name

try {
    // Prepare the SQL query to fetch the username
    $sql = "SELECT UserName FROM admin LIMIT 1";
    $query = $dbh->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result && isset($result['UserName'])) {
        $adminName = htmlspecialchars($result['UserName']); 
    }
} catch (PDOException $e) {
    error_log("Error fetching admin username: " . $e->getMessage());
}
?>

 




<!DOCTYPE html>
<html lang="en" class="group" data-sidebar-size="lg">
 <head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>VEx - Admin & Dashboard</title>
  <meta name="description" content="">
  <meta name="title" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/x-icon" href="newassets/fev.png">
  <link rel="stylesheet" href="assets/css/vendor/select/select2.min.css">
  <link rel="stylesheet" href="assets/css/vendor/summernote.min.css">
  <link rel="stylesheet" href="assets/css/output.css">
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <style>
    /* From Uiverse.io by r7chardgh */ 
/* The switch - the box around the slider */
.switch {
      font-size: 17px;
      position: relative;
      display: inline-block;
      width: 5em;
      height: 2.5em;
      user-select: none;
    }

    .switch .cb {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .toggle {
      position: absolute;
      cursor: pointer;
      width: 100%;
      height: 100%;
      background-color: #373737;
      border-radius: 0.1em;
      transition: 0.4s;
      text-transform: uppercase;
      font-weight: 700;
      overflow: hidden;
      box-shadow: -0.3em 0 0 0 #373737, -0.3em 0.3em 0 0 #373737,
        0.3em 0 0 0 #373737, 0.3em 0.3em 0 0 #373737, 0 0.3em 0 0 #373737;
    }

    .toggle > .left {
      position: absolute;
      display: flex;
      width: 50%;
      height: 88%;
      background-color: #f3f3f3;
      color: #373737;
      left: 0;
      bottom: 0;
      align-items: center;
      justify-content: center;
      transform-origin: right;
      transform: rotateX(10deg);
      transform-style: preserve-3d;
      transition: all 150ms;
    }

    .left::before {
      position: absolute;
      content: "";
      width: 100%;
      height: 100%;
      background-color: rgb(206, 206, 206);
      transform-origin: center left;
      transform: rotateY(90deg);
    }

    .left::after {
      position: absolute;
      content: "";
      width: 100%;
      height: 100%;
      background-color: rgb(112, 112, 112);
      transform-origin: center bottom;
      transform: rotateX(90deg);
    }

    .toggle > .right {
      position: absolute;
      display: flex;
      width: 50%;
      height: 88%;
      background-color: #f3f3f3;
      color: rgb(206, 206, 206);
      right: 1px;
      bottom: 0;
      align-items: center;
      justify-content: center;
      transform-origin: left;
      transform: rotateX(10deg) rotateY(-45deg);
      transform-style: preserve-3d;
      transition: all 150ms;
    }

    .right::before {
      position: absolute;
      content: "";
      width: 100%;
      height: 100%;
      background-color: rgb(206, 206, 206);
      transform-origin: center right;
      transform: rotateY(-90deg);
    }

    .right::after {
      position: absolute;
      content: "";
      width: 100%;
      height: 100%;
      background-color: rgb(112, 112, 112);
      transform-origin: center bottom;
      transform: rotateX(90deg);
    }

    .switch input:checked + .toggle > .left {
      transform: rotateX(10deg) rotateY(45deg);
      color: rgb(206, 206, 206);
    }

    .switch input:checked + .toggle > .right {
      transform: rotateX(10deg) rotateY(0deg);
      color: #487bdb;
    }


    

  </style>
  </head>