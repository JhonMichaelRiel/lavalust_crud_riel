<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in | ProductHub</title>
    <style>
        :root { font-family: Arial, sans-serif; color: #f5f7f2; background: #111719; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; background: radial-gradient(circle at 12% 18%, #1d3532 0, transparent 34%), #111719; }
        .page { display: grid; grid-template-columns: minmax(0, 1.1fr) minmax(360px, .9fr); min-height: 100vh; width: min(1180px, 100%); margin: auto; padding: 42px 56px; gap: 72px; align-items: center; }
        .brand { color: #a6e86b; font-size: 15px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; }
        h1 { max-width: 650px; margin: 28px 0 20px; font-size: clamp(48px, 7vw, 88px); line-height: .95; letter-spacing: -.05em; }
        h1 span { color: #a6e86b; }
        .intro { max-width: 540px; color: #a6b5b0; font-size: 18px; line-height: 1.6; }
        .features { display: grid; gap: 14px; margin-top: 42px; color: #dce6e0; font-size: 14px; }
        .features div { display: flex; gap: 12px; align-items: center; }
        .check { display: grid; width: 24px; height: 24px; place-items: center; border-radius: 50%; background: #a6e86b; color: #142019; font-weight: 900; }
        .card { padding: 38px; border: 1px solid #30423f; border-radius: 18px; background: rgba(26, 35, 36, .94); box-shadow: 0 24px 70px rgba(0, 0, 0, .25); }
        .card h2 { margin: 0 0 10px; font-size: 31px; }
        .card p { margin: 0 0 28px; color: #94a5a0; line-height: 1.5; }
        label { display: block; margin: 18px 0 8px; color: #d5dfda; font-size: 12px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
        input { width: 100%; padding: 15px 16px; border: 1px solid #3c504c; border-radius: 9px; outline: 0; background: #121a1b; color: #fff; font-size: 16px; }
        input:focus { border-color: #a6e86b; box-shadow: 0 0 0 3px rgba(166, 232, 107, .12); }
        button { width: 100%; margin-top: 26px; padding: 15px; border: 0; border-radius: 9px; background: #a6e86b; color: #142019; font-size: 15px; font-weight: 900; cursor: pointer; }
        a { color: #a6e86b; font-weight: 700; text-decoration: none; }
        .card .foot { margin-top: 24px; color: #8fa09b; font-size: 14px; text-align: center; }
        .password-wrap { position: relative; }
        .password-wrap input { padding-right: 48px; }
        .toggle-password { position: absolute; top: 50%; right: 10px; display: grid; width: 30px; height: 30px; margin-top: 0; place-items: center; transform: translateY(-50%); padding: 0; border: 0; background: transparent; color: #a6e86b; cursor: pointer; }
        .toggle-password:hover { color: #d2f6ad; }
        .toggle-password svg { width: 19px; height: 19px; }
        .alert { margin-bottom: 16px; padding: 12px; border-radius: 8px; background: #512b2b; color: #ffb6a8; font-size: 14px; }
        .success { background: #23452d; color: #c4f3a4; }
        .footer { position: fixed; right: 56px; bottom: 24px; color: #667773; font-size: 12px; }
        @media (max-width: 800px) { .page { display: block; padding: 30px 20px; } .intro { font-size: 16px; } .features { margin: 25px 0 32px; } .card { padding: 26px; } .footer { position: static; margin-top: 26px; } }
    </style>
</head>
<body>
    <main class="page">
        <section>
            <div class="brand">ProductHub.</div>
            <h1>Welcome to <span>ProductHub.</span></h1>
            <p class="intro">A clean and secure inventory workspace built for your LavaLust CRUD laboratory exercise.</p>
            <div class="features">
                <div><span class="check">&#10003;</span> Authenticated access and protected product management</div>
                <div><span class="check">&#10003;</span> Create, update, view, and delete products</div>
            </div>
        </section>
        <section class="card">
            <h2>Sign in</h2>
            <p>Enter your account to continue to the dashboard.</p>
            <?php if (!empty($error)): ?><div class="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
            <?php if (!empty($success)): ?><div class="alert success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
            <form method="post" action="<?= site_url('login') ?>">
                <label for="username">Username</label>
                <input id="username" name="username" required autofocus>
                <label for="password">Password</label>
                <div class="password-wrap">
                    <input id="password" type="password" name="password" required>
                    <button class="toggle-password" type="button" id="toggle-password" aria-label="Show password" aria-controls="password" aria-pressed="false">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>
                </div>
                <button type="submit">Sign in &rarr;</button>
            </form>
            <div class="foot">New here? <a href="<?= site_url('register') ?>">Create an account</a></div>
        </section>
        <div class="footer">LavaLust &bull; Laboratory Exercise No. 5</div>
    </main>
    <script>
        const password = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');

        const eyeIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
        const eyeOffIcon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m3 3 18 18"></path><path d="M10.6 5.1A10.8 10.8 0 0 1 12 5c6.5 0 10 7 10 7a18.5 18.5 0 0 1-3.1 3.9"></path><path d="M6.6 6.6C3.7 8.7 2 12 2 12s3.5 7 10 7c1.3 0 2.5-.3 3.6-.8"></path><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"></path></svg>';

        togglePassword.addEventListener('click', function () {
            const isVisible = password.type === 'text';
            password.type = isVisible ? 'password' : 'text';
            togglePassword.innerHTML = isVisible ? eyeIcon : eyeOffIcon;
            togglePassword.setAttribute('aria-label', isVisible ? 'Show password' : 'Hide password');
            togglePassword.setAttribute('aria-pressed', String(!isVisible));
        });
    </script>
</body>
</html>
