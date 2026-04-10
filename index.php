<?php
require_once 'db.php';
$pdo = require 'db.php';

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        text VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $count = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
    if ($count == 0) {
        $pdo->exec("INSERT INTO messages (text) VALUES ('I am exploring the use of AWS Lightsail with the NOUN application')");
    }

    $messages = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC")->fetchAll();
} catch (Exception $e) {
    $error = "Unable to load data. Please check database connection.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oladimeji - NOUN | AWS Lightsail Exploration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.75)), 
                        url('https://source.unsplash.com/random/1920x1080/?aws,cloud,technology') center/cover no-repeat fixed;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
        }
    </style>
</head>
<body class="min-h-screen text-gray-800">
    <div class="max-w-4xl mx-auto pt-12 px-6">
        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-3 bg-white/90 px-6 py-3 rounded-2xl shadow mb-6">
                <i class="fa-solid fa-cloud text-4xl text-blue-600"></i>
                <h1 class="text-4xl font-bold tracking-tight">AWS Lightsail Explorer</h1>
            </div>
            <p class="text-2xl font-medium text-white">Oladimeji • NOUN Application • 2026</p>
        </div>

        <!-- Main Card -->
        <div class="glass rounded-3xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white p-10">
                <h2 class="text-3xl font-bold mb-3">"I am exploring the use of AWS Lightsail"</h2>
                <p class="text-lg opacity-90">A monolithic PHP + MySQL application deployed using Docker and ECR</p>
            </div>

            <div class="p-10 space-y-10">
                <!-- Write-up Section -->
                <div>
                    <h3 class="text-xl font-semibold mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-info-circle"></i> About AWS Lightsail
                    </h3>
                    <div class="prose text-gray-700">
                        <p>AWS Lightsail is Amazon's simplified Virtual Private Server (VPS) service designed for developers and small teams. It bundles compute, storage, networking, and databases with predictable monthly pricing, making it far easier to use than raw EC2.</p>
                        <p><strong>Key Differences from Traditional WordPress Hosting:</strong></p>
                        <ul class="list-disc pl-6 space-y-2">
                            <li><strong>Full Control vs Limited:</strong> Root/SSH access and custom code (PHP, Docker) instead of shared hosting restrictions.</li>
                            <li><strong>Predictable Pricing:</strong> Fixed monthly cost including bandwidth allowance (unlike EC2 variable costs).</li>
                            <li><strong>Simplicity + Scalability:</strong> One-click instances and managed databases, yet easy to scale or migrate to full AWS services later.</li>
                            <li><strong>Flexibility:</strong> Run any application stack, not just WordPress blueprints.</li>
                        </ul>
                    </div>
                </div>

                <!-- Database Data Section -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-semibold flex items-center gap-3">
                            <i class="fa-solid fa-database text-indigo-600"></i>
                            Live Data from MySQL Database
                        </h3>
                        <button onclick="window.location.reload()" 
                                class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-medium transition-all">
                            <i class="fa-solid fa-arrows-rotate"></i> Refresh Data
                        </button>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-2xl">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php else: ?>
                        <div class="grid gap-4">
                            <?php foreach ($messages as $msg): ?>
                                <div class="card-hover bg-white border border-gray-200 p-6 rounded-2xl transition-all">
                                    <p class="text-lg text-gray-800"><?= htmlspecialchars($msg['text']) ?></p>
                                    <p class="text-sm text-gray-500 mt-3">
                                        <?= date('F j, Y • g:i A', strtotime($msg['created_at'])) ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Health Check -->
                <div class="text-center pt-6 border-t">
                    <a href="/health" 
                       class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-medium text-lg">
                        <i class="fa-solid fa-heart-pulse"></i> 
                        Check Health Endpoint →
                    </a>
                </div>
            </div>
        </div>

        <footer class="text-center text-white/70 text-sm mt-10 pb-8">
            Built with PHP 8.3 • Docker • Amazon ECR • Lightsail (Paris Region) • 2026
        </footer>
    </div>
</body>
</html>