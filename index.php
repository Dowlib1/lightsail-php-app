<?php
// index.php
require_once 'db.php';   // This now uses secure env vars

$pdo = require 'db.php';  // Get the PDO connection

// Rest of your code (create table, fetch messages, etc.)
try {
    // Create table if not exists
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        text VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // Insert sample data if empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM messages");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO messages (text) VALUES ('I am exploring the use of AWS Lightsail with NOUN app by Oladimeji')");
    }

    $messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();

} catch (Exception $e) {
    $error = "Error fetching data: " . $e->getMessage();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Lightsail PHP App</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body { font-family: Arial, sans-serif; margin: 2rem; }
    .container { max-width: 700px; margin: auto; }
    button { padding: 0.5rem 1rem; font-size: 1rem; }
    #output { margin-top: 1rem; background:#f6f6f6; padding:1rem; border-radius:4px; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Lightsail PHP App</h1>
    <p><strong>Message:</strong> I am exploring the use of AWS Lightsail</p>

    <p>
      <button id="fetchBtn">Fetch messages from DB</button>
    </p>

    <div id="output">Click the button to load messages from the database.</div>

    <h2>Write-up: What is AWS Lightsail?</h2>
    <p>
      AWS Lightsail is a simplified VPS-style service from AWS offering instances, managed databases, networking and storage with an easy-to-use console and predictable pricing. It's targeted at simpler workloads and single-server deployments. It differs from traditional managed WordPress hosting because Lightsail gives you raw compute instances and/or managed databases (you manage the web server, install PHP, run code), whereas managed WordPress hosting is specialized (preconfigured WordPress, built-in backups, plugin/theme management, and WordPress-optimized stacks).
    </p>

    <h3>Health endpoint</h3>
    <p>Check <a href="/health.php">/health.php</a> to verify app availability.</p>
  </div>

  <script>
    document.getElementById('fetchBtn').addEventListener('click', async () => {
      const out = document.getElementById('output');
      out.textContent = 'Loading...';
      try {
        const res = await fetch('fetch.php');
        if (!res.ok) throw new Error('Network response was not ok');
        const data = await res.json();
        if (data.error) {
          out.textContent = 'Error: ' + data.error;
          return;
        }
        if (!data.messages || !data.messages.length) {
          out.innerHTML = '<em>No messages found</em>';
          return;
        }
        out.innerHTML = '<ul>' + data.messages.map(m => `<li>${m.id}: ${escapeHtml(m.text)}</li>`).join('') + '</ul>';
      } catch (err) {
        out.textContent = 'Fetch failed: ' + err.message;
      }
    });

    function escapeHtml(str) {
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
    }
  </script>
</body>
</html>