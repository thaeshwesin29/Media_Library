<?php $title = "Validation Error"; ?>

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .container {
        width: 90%;
        max-width: 700px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.5);
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .title {
        font-size: 26px;
        font-weight: bold;
        color: #f87171;
        margin-bottom: 10px;
    }

    .subtitle {
        color: #cbd5e1;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .error-box {
        background: rgba(0,0,0,0.4);
        border-left: 4px solid #ef4444;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .error-item {
        margin-bottom: 8px;
        color: #fca5a5;
        font-size: 14px;
    }

    .btn {
        display: inline-block;
        padding: 10px 18px;
        background: linear-gradient(90deg, #3b82f6, #06b6d4);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: 0.3s;
        font-weight: 500;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59,130,246,0.5);
    }

    .back {
        display: block;
        margin-top: 15px;
        color: #94a3b8;
        font-size: 14px;
        text-decoration: none;
    }

    .back:hover {
        color: #fff;
    }
</style>

<div class="container">
    <div class="title">⚠ Validation Failed</div>

    <div class="subtitle">
        Please fix the following errors before continuing.
    </div>

    <div class="error-box">
        <?php if (!empty($response['errors'] ?? [])): ?>
            <?php foreach ($response['errors'] as $field => $message): ?>
                <div class="error-item">
                    <strong><?= htmlspecialchars($field) ?>:</strong>
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="error-item">
                Unknown validation error occurred.
            </div>
        <?php endif; ?>
    </div>

    <a href="javascript:history.back()" class="btn">
        Fix & Try Again
    </a>

    <a href="<?= BASE_URL ?>/Public/index.php?page=home" class="back">
        Back to Home
    </a>
</div>