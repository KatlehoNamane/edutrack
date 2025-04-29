<?php
include "navbar.php"
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #eee;
      color: #000;
    }

    header {
      background-color: #ff6600;
      color: white;
      padding: 1rem;
      text-align: center;
    }

    .contact-container {
      max-width: 600px;
      margin: 2rem auto;
      padding: 2rem;
      background-color: #fff4e6;
      border: 1px solid #ff6600;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .contact-container h2 {
      color: #ff6600;
    }

    label {
      display: block;
      margin: 1rem 0 0.5rem;
    }

    input,
    textarea {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      margin-top: 1rem;
      background-color: #ff6600;
      color: white;
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background-color: #e65c00;
    }
  </style>
</head>
<body>

  <div class="contact-container">
    <h2>Get in Touch</h2>
    <form>
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="message">Message</label>
      <textarea id="message" name="message" rows="5" required></textarea>

      <button type="submit">Send Message</button>
    </form>
  </div>
</body>
</html>
