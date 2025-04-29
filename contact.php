<?php
include "navbar.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us</title>
  <link rel="stylesheet" href="footer.css">
<style>
  :root {
    --primary: #ff6600;
    --primary-dark: #e65c00;
    --bg-light: #f9f9f9;
    --card-bg: #ffffff;
    --text-dark: #333333;
    --border: #dddddd;
  }

  .contact-card {
    max-width: 480px;
    margin: 3rem auto;
    padding: 2rem;
    background: var(--card-bg);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    font-family: 'Segoe UI', Tahoma, sans-serif;
  }
  .contact-card h2 {
    margin-bottom: 1.5rem;
    color: var(--text-dark);
    text-align: center;
    font-size: 1.75rem;
    font-weight: 600;
  }
  .form-group {
    margin-bottom: 1.25rem;
  }
  .form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-dark);
  }
  .form-group input,
  .form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border);
    border-radius: 4px;
    font-size: 1rem;
    background: var(--bg-light);
    transition: border-color 0.2s;
  }
  .form-group input:focus,
  .form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
  }
  .btn-send {
    display: block;
    width: 80%;
    text-align: center;
    padding: 0.85rem;
    background: var(--primary);
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    font-weight: 600;
    transition: background 0.2s;
    margin: auto;
  }
  .btn-send:hover {
    background: var(--primary-dark);
  }
</style>
</head>
<body>

<div class="contact-card">
  <h2>Contact Us</h2>
  <form id="contactForm">
    <div class="form-group">
      <label for="name">Your Name</label>
      <input type="text" id="name" name="name" placeholder="John Doe" required>
    </div>
    <div class="form-group">
      <label for="email">Your Email</label>
      <input type="email" id="email" name="email" placeholder="you@example.com" required>
    </div>
    <div class="form-group">
      <label for="message">Your Message</label>
      <textarea id="message" name="message" rows="5" placeholder="How can we help you?" required></textarea>
    </div>
    <!-- Styled anchor acting as a submit button -->
    <a href="#" id="sendMessage" class="btn-send">Send Message</a>
  </form>
</div>

<?php
    include "footer.php"
    ?>

<script>
  document.getElementById('sendMessage').addEventListener('click', function(e) {
    e.preventDefault();
    const nameField    = document.getElementById('name').value.trim();
    const emailField   = document.getElementById('email').value.trim();
    const messageField = document.getElementById('message').value.trim();

    if (!nameField || !emailField || !messageField) {
      alert('Please fill out all fields before sending.');
      return;
    }

    const subject = encodeURIComponent('New Contact Message from ' + nameField);
    const bodyLines = [
      'Name: '    + nameField,
      'Email: '   + emailField,
      '',
      'Message:',
      messageField
    ];
    const body = encodeURIComponent(bodyLines.join('\n'));

    window.location.href = 
      'mailto:isabellakn14@gmail.com'
      + '?subject=' + subject
      + '&body='    + body;
  });
</script>
</body>
</html>
