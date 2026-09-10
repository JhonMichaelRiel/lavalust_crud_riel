<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$view_data = get_defined_vars();
$products = is_array($view_data['products'] ?? null) ? $view_data['products'] : [];
$message = $view_data['message'] ?? null;
$total_products = count($products);
$total_quantity = array_sum(array_map(static function ($product) {
    return (int) ($product['quantity'] ?? 0);
}, $products));
$total_value = array_sum(array_map(static function ($product) {
    return (float) ($product['price'] ?? 0) * (int) ($product['quantity'] ?? 0);
}, $products));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products | ProductHub</title>
    <style>
        :root { font-family: Arial, sans-serif; color: #f5f7f2; background: #111719; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; background: radial-gradient(circle at 80% 0, #1d3532 0, transparent 30%), #111719; }
        .shell { width: min(1180px, calc(100% - 64px)); margin: 0 auto; padding: 28px 0 55px; }
        .topbar { display: flex; justify-content: space-between; align-items: center; padding-bottom: 28px; border-bottom: 1px solid #30423f; }
        .brand { color: #a6e86b; font-size: 15px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; }
        .nav { display: flex; gap: 20px; align-items: center; }
        .nav a { color: #aebdb7; font-size: 13px; font-weight: 700; text-decoration: none; }
        .nav a:hover { color: #a6e86b; }
        .logout { padding: 10px 14px; border: 1px solid #3c504c; border-radius: 8px; color: #dce6e0 !important; }
        .hero { display: flex; justify-content: space-between; align-items: end; gap: 24px; padding: 52px 0 34px; }
        .eyebrow { color: #a6e86b; font-size: 12px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; }
        h1 { margin: 12px 0 10px; font-size: clamp(42px, 6vw, 72px); line-height: .95; letter-spacing: -.05em; }
        .subtle { color: #91a39d; line-height: 1.5; }
        .primary { display: inline-block; padding: 14px 18px; border-radius: 9px; background: #a6e86b; color: #142019; font-weight: 900; text-decoration: none; white-space: nowrap; }
        .notice { margin-bottom: 22px; padding: 13px 16px; border: 1px solid #4b7650; border-radius: 9px; background: #23452d; color: #c4f3a4; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 26px; }
        .stat { padding: 20px; border: 1px solid #30423f; border-radius: 12px; background: #1a2324; }
        .stat-label { color: #91a39d; font-size: 12px; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; }
        .stat-value { margin-top: 10px; color: #fff; font-size: 28px; font-weight: 800; }
        .table-wrap { overflow-x: auto; border: 1px solid #30423f; border-radius: 14px; background: #1a2324; }
        table { width: 100%; min-width: 760px; border-collapse: collapse; }
        th, td { padding: 17px 18px; border-bottom: 1px solid #2b3a39; text-align: left; }
        th { color: #91a39d; font-size: 11px; letter-spacing: .12em; text-transform: uppercase; }
        td { color: #dce6e0; font-size: 14px; }
        tbody tr:last-child td { border-bottom: 0; }
        td strong { color: #fff; font-size: 16px; }
        .description { max-width: 280px; color: #91a39d; }
        .price { color: #a6e86b; font-weight: 800; }
        .actions { white-space: nowrap; }
        .actions a { margin-right: 14px; color: #a6e86b; font-size: 13px; font-weight: 800; text-decoration: none; }
        .actions .danger { color: #ff9b8c; }
        .empty { padding: 48px; color: #91a39d; text-align: center; }
        footer { padding-top: 24px; color: #667773; font-size: 12px; }
        @media (max-width: 700px) {
            .shell { width: min(100% - 32px, 1180px); padding-top: 20px; }
            .topbar, .hero { align-items: flex-start; flex-direction: column; }
            .hero { padding-top: 38px; }
            .primary { width: 100%; text-align: center; }
            .stats { grid-template-columns: 1fr; }
            .nav { width: 100%; justify-content: space-between; }
        }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div class="brand">ProductHub.</div>
            <nav class="nav">
                <a href="<?= site_url('products') ?>">Products</a>
                <a class="logout" href="<?= site_url('logout') ?>">Log out</a>
            </nav>
        </header>

        <section class="hero">
            <div>
                <div class="eyebrow">Authenticated workspace / Inventory</div>
                <h1>Product catalog.</h1>
                <div class="subtle">Manage your products, pricing, and available stock.</div>
            </div>
            <a class="primary" href="<?= site_url('products/create') ?>">+ Add product</a>
        </section>

        <?php if ($message): ?>
            <div class="notice"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <section class="stats" aria-label="Inventory summary">
            <div class="stat"><div class="stat-label">Products</div><div class="stat-value"><?= $total_products ?></div></div>
            <div class="stat"><div class="stat-label">Units in stock</div><div class="stat-value"><?= $total_quantity ?></div></div>
            <div class="stat"><div class="stat-label">Inventory value</div><div class="stat-value">&#8369;<?= number_format($total_value, 2) ?></div></div>
        </section>

        <section class="table-wrap">
            <table>
                <thead>
                    <tr><th>Product</th><th>Description</th><th>Price</th><th>Quantity</th><th>Created</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <?php if (!$products): ?>
                        <tr><td class="empty" colspan="6">No products yet. Add your first product to the catalog.</td></tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($product['product_name'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong></td>
                                <td class="description"><?= htmlspecialchars($product['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="price">&#8369;<?= number_format((float) ($product['price'] ?? 0), 2) ?></td>
                                <td><?= (int) ($product['quantity'] ?? 0) ?></td>
                                <td class="subtle"><?= htmlspecialchars($product['created_at'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="actions">
                                    <a href="<?= site_url('products/edit/' . (int) ($product['id'] ?? 0)) ?>">Edit</a>
                                    <a class="danger" href="<?= site_url('products/delete/' . (int) ($product['id'] ?? 0)) ?>" onclick="return confirm('Delete this product?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
