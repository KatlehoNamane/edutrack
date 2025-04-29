<?php
include "navbar.php"
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Once-off</title>
        <style>
             body {
      background-color:#eee ;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      /* padding: 2rem; */
      border:2px solid white;
      color:rgba(250, 118, 23, .9) 
    }

    h2 {
      margin-bottom: 1rem;
      text-align:center;
      margin-top:10%
    }

    .item-list {
      display: flex;
      flex-direction:column;
      gap: 1rem;
      align-items:center;
      padding:80px 20px
    }

    .radio-container {
      display: flex;
      align-items: center;
      cursor: pointer;
      user-select: none;
      font-size: 1.1rem;
    }

    .radio-container input {
      display: none;
    }

    .radiomark {
      width: 22px;
      height: 22px;
      border: 2px solid #eee;
      border-radius: 50%;
      margin-right: 10px;
      position: relative;
      transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .radio-container:hover .radiomark {
      transform: scale(1.05);
    }

    .radiomark::after {
      content: "";
      position: absolute;
      top: 5px;
      left: 5px;
      width: 10px;
      height: 10px;
      background-color:rgba(250, 118, 23, .9) ;
      border-radius: 50%;
      transform: scale(0);
      transition: transform 0.3s ease;
    }

    .radio-container input:checked + .radiomark::after {
      transform: scale(1);
    }
           .form-container {
                align-items: center;
                width: 500px;
                border-radius: 0.6em;
                padding: 20px;
                background-color:#281500 ;
                box-shadow: 0px 0px 5px  black;
                margin: 60px auto;
                max-height:fit-content;

           }
        </style>
    </head>
    <body>
<div class="form-container">
  <h2>Select One Category</h2>
  <form>
  <div class="item-list">
    <label class="radio-container">
      <input type="radio" name="Role" value="teacher">
      <span class="radiomark"></span>
      Teacher
    </label>
    <label class="radio-container">
      <input type="radio" name="Role" value="principal">
      <span class="radiomark"></span>
      Principal
    </label>
        </div>
    </form>
    </div>
    </body>
</html>