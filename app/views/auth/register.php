<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create account | ProductHub</title>
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
        label { display: block; margin: 15px 0 8px; color: #d5dfda; font-size: 12px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
        input { width: 100%; padding: 14px 16px; border: 1px solid #3c504c; border-radius: 9px; outline: 0; background: #121a1b; color: #fff; font-size: 16px; }
        input:focus { border-color: #a6e86b; box-shadow: 0 0 0 3px rgba(166, 232, 107, .12); }
        button { width: 100%; margin-top: 24px; padding: 15px; border: 0; border-radius: 9px; background: #a6e86b; color: #142019; font-size: 15px; font-weight: 900; cursor: pointer; }
        a { color: #a6e86b; font-weight: 700; text-decoration: none; }
        .foot { margin-top: 24px; color: #8fa09b; font-size: 14px; text-align: center; }
        .alert { margin-bottom: 16px; padding: 12px; border-radius: 8px; background: #512b2b; color: #ffb6a8; font-size: 14px; }
        .footer { position: fixed; right: 56px; bottom: 24px; color: #667773; font-size: 12px; }
        @media (max-width: 800px) { .page { display: block; padding: 30px 20px; } .intro { font-size: 16px; } .features { margin: 25px 0 32px; } .card { padding: 26px; } .footer { position: static; margin-top: 26px; } }
    </style>
</head>
<body>
    <main class="page">
        <section>
            <div class="brand">ProductHub.</div>
            <h1>Build your <span>workspace.</span></h1>
            <p class="intro">Create a secure account and keep your product inventory organized in one place.</p>
            <div class="features">
                <div><span class="check">&#10003;</span> Protected account access</div>
                <div><span class="check">&#10003;</span> Simple inventory management</div>
            </div>
        </section>
        <section class="card">
            <h2>Create account</h2>
            <p>Register to continue to the product dashboard.</p>
            <?php if (!empty($error)): ?><div class="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
            <form method="post" action="<?= site_url('register') ?>">
                <label for="username">Username</label>
                <input id="username" name="username" required>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" required>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" minlength="6" required>
                <button type="submit">Create account &rarr;</button>
            </form>
            <div class="foot">Already registered? <a href="<?= site_url('login') ?>">Sign in</a></div>
        </section>
        <div class="footer">LavaLust &bull; Laboratory Exercise No. 5</div>
    </main>
</body>
</html>
