<?php require BASE_PATH . '/resources/views/layout/header.php'; ?>

<div class="register-wrapper">
    <div class="register-box">
        <div class="register-header">
            <h1>Media Library</h1>
            <p class="welcome-text">Create your account</p>
        </div>

        <!-- GLOBAL ERRORS -->
        <?php if (!empty($errors)): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= BASE_URL ?>/Public/index.php?page=register-submit">

            <!-- NAME -->
            <div class="field">
                <label>Full name</label>
                <input type="text" 
                       name="name"
                       placeholder="John Doe"
                       value="<?= htmlspecialchars($old['name'] ?? '') ?>">

                <?php if (!empty($errors['name'])): ?>
                    <small class="error"><?= $errors['name'] ?></small>
                <?php endif; ?>
            </div>

            <!-- EMAIL -->
            <div class="field">
                <label>Email address</label>
                <input type="email" 
                       name="email"
                       placeholder="you@example.com"
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>">

                <?php if (!empty($errors['email'])): ?>
                    <small class="error"><?= $errors['email'] ?></small>
                <?php endif; ?>
            </div>

            <!-- PASSWORD -->
            <div class="field">
                <label>Password</label>
                <input type="password" 
                       name="password"
                       placeholder="••••••••">

                <?php if (!empty($errors['password'])): ?>
                    <small class="error"><?= $errors['password'] ?></small>
                <?php endif; ?>
            </div>

            <!-- CONFIRM PASSWORD -->
            <div class="field">
                <label>Confirm password</label>
                <input type="password" 
                       name="confirm_password"
                       placeholder="••••••••">

                <?php if (!empty($errors['confirm_password'])): ?>
                    <small class="error"><?= $errors['confirm_password'] ?></small>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-primary">
                Create account
            </button>
        </form>

        <div class="signup-prompt">
            Already have an account?
            <a href="/index.php?page=login">Sign in</a>
        </div>
    </div>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #f8fafc;
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
}

.register-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.register-box {
    max-width: 400px;
    width: 100%;
    background: #ffffff;
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.register-header {
    margin-bottom: 2rem;
}

.register-header h1 {
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

.error-message ul {
    margin-left: 1.25rem;
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

.field input::placeholder {
    color: #cbd5e1;
}

.field .error {
    display: block;
    margin-top: 0.5rem;
    font-size: 0.75rem;
    color: #ef4444;
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
    margin-top: 0.5rem;
}

.btn-primary:hover {
    background: #1e293b;
    transform: translateY(-1px);
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
    margin-left: 0.25rem;
}

.signup-prompt a:hover {
    text-decoration: underline;
}

@media (max-width: 480px) {
    .register-box {
        padding: 1.5rem;
    }
}
</style>

<?php require BASE_PATH . '/resources/views/layout/footer.php'; ?>