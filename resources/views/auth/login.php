<?php require BASE_PATH . '/resources/views/layout/header.php'; ?>

<div class="login-wrapper">
    <div class="login-box">
        <div class="login-header">
            <h1>Media Library</h1>
            <p class="welcome-text">Welcome back</p>
        </div>

        <!-- GLOBAL ERRORS -->
        <?php if (!empty($_SESSION['flash_error']) || !empty($errors)): ?>
            <div class="error-message">

                <?php if (!empty($_SESSION['flash_error'])): ?>
                    <?= $_SESSION['flash_error'] ?>
                    <?php unset($_SESSION['flash_error']); ?>
                <?php endif; ?>

                <?php if (!empty($errors)): ?>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

            </div>
        <?php endif; ?>

<form method="post" action="<?= BASE_URL ?>/Public/index.php?page=login-submit">
            <!-- EMAIL -->
            <div class="field">
                <label>Email address</label>
                <input type="email"
                       name="email"
                       placeholder="you@example.com"
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                       >

                <?php if (!empty($errors['email'])): ?>
                    <small class="error"><?= $errors['email'] ?></small>
                <?php endif; ?>
            </div>

            <!-- PASSWORD -->
            <div class="field">
                <label>Password</label>
                <input type="password"
                       name="password"
                       placeholder="••••••••"
                       >

                <?php if (!empty($errors['password'])): ?>
                    <small class="error"><?= $errors['password'] ?></small>
                <?php endif; ?>
            </div>

            <div class="row">
                <label class="checkbox">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
                <a href="#" class="forgot">Forgot password?</a>
            </div>

            <button type="submit" class="btn-primary">
                Sign in
            </button>
        </form>

        <div class="signup-prompt">
            New to Media Library?
            <a href="/index.php?page=register">Create an account</a>
        </div>
    </div>
</div>

<style>
/* YOUR CSS - UNCHANGED */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #f8fafc;
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
}

.login-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.login-box {
    max-width: 400px;
    width: 100%;
    background: #ffffff;
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.login-header {
    margin-bottom: 2rem;
}

.login-header h1 {
    font-size: 1.75rem;
    font-weight: 600;
    color: #0f172a;
    letter-spacing: -0.02em;
    margin-bottom: 0.5rem;
}

.welcome-text {
    font-size: 0.875rem;
    color: #475569;
    border-left: 3px solid #3b82f6;
    padding-left: 0.75rem;
    margin-top: 0.5rem;
}

.error-message {
    background: #fef2f2;
    border-left: 4px solid #ef4444;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    color: #b91c1c;
    margin-bottom: 1.5rem;
}

.field {
    margin-bottom: 1.25rem;
}

.field label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.field input {
    width: 100%;
    padding: 0.7rem 0.9rem;
    font-size: 0.9rem;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    background: #ffffff;
    transition: all 0.2s ease;
    font-family: inherit;
    color: #0f172a;
}

.field input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
}

.row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 1.5rem 0 1.75rem;
}

.checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #334155;
    cursor: pointer;
}

.checkbox input {
    width: 1rem;
    height: 1rem;
    accent-color: #3b82f6;
}

.forgot {
    font-size: 0.875rem;
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
}

.btn-primary {
    width: 100%;
    background: #0f172a;
    color: white;
    padding: 0.75rem;
    border: none;
    border-radius: 40px;
    font-size: 0.9rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    font-family: inherit;
}

.signup-prompt {
    text-align: center;
    margin-top: 1.75rem;
    font-size: 0.875rem;
    color: #475569;
    border-top: 1px solid #f1f5f9;
    padding-top: 1.5rem;
}

.signup-prompt a {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
}
</style>

<?php require BASE_PATH . '/resources/views/layout/footer.php'; ?>