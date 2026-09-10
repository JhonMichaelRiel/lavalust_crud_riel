<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$view_data = get_defined_vars();
$product = is_array($view_data['product'] ?? null) ? $view_data['product'] : [];
$heading = $view_data['heading'] ?? 'Product';
$action = $view_data['action'] ?? site_url('products');
$error = $view_data['error'] ?? null;
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?> | ProductHub</title>
	<style>
		:root { font-family: Arial, sans-serif; color: #f5f7f2; background: #111719; }
		* { box-sizing: border-box; }
		body { min-height: 100vh; margin: 0; background: radial-gradient(circle at 12% 18%, #1d3532 0, transparent 34%), #111719; }
		.shell { display: grid; grid-template-columns: minmax(0, .8fr) minmax(420px, 1.2fr); gap: 70px; align-items: center; width: min(1120px, calc(100% - 112px)); min-height: 100vh; margin: auto; }
		.intro { max-width: 390px; }
		.brand { color: #a6e86b; font-size: 15px; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; }
		.intro h1 { margin: 28px 0 18px; font-size: clamp(46px, 6vw, 76px); line-height: .95; letter-spacing: -.05em; }
		.intro h1 span { color: #a6e86b; }
		.intro p { color: #a6b5b0; font-size: 17px; line-height: 1.6; }
		.back { display: inline-block; margin-top: 28px; color: #a6e86b; font-weight: bold; text-decoration: none; }
		.panel { padding: 38px; border: 1px solid #30423f; border-radius: 18px; background: rgba(26, 35, 36, .94); box-shadow: 0 24px 70px rgba(0, 0, 0, .25); }
		.eyebrow { color: #a6e86b; font-size: 12px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
		h1 { margin: 10px 0 25px; font-size: 32px; }
		label { display: block; margin: 18px 0 8px; color: #d5dfda; font-size: 12px; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
		input, textarea { width: 100%; padding: 15px 16px; border: 1px solid #3c504c; border-radius: 9px; outline: 0; background: #121a1b; color: #fff; font: 16px Arial, sans-serif; }
		input:focus, textarea:focus { border-color: #a6e86b; box-shadow: 0 0 0 3px rgba(166, 232, 107, .12); }
		textarea { min-height: 130px; resize: vertical; }
		.row { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
		.buttons { display: flex; gap: 12px; margin-top: 28px; }
		.button { border: 0; border-radius: 9px; padding: 15px 18px; background: #a6e86b; color: #142019; font-weight: 900; text-decoration: none; cursor: pointer; }
		.button.secondary { border: 1px solid #3c504c; background: transparent; color: #dce6e0; }
		.alert { padding: 12px; border-radius: 8px; background: #512b2b; color: #ffb6a8; font-size: 14px; }
		.footer { margin-top: 25px; color: #667773; font-size: 12px; }
		@media (max-width: 800px) { .shell { display: block; width: min(100% - 40px, 620px); padding: 35px 0; } .intro { margin-bottom: 35px; } .panel { padding: 26px; } }
		@media (max-width: 600px) { .row { grid-template-columns: 1fr; } .buttons > * { flex: 1; text-align: center; } }
	</style>
</head>
<body>
	<div class="shell">
		<section class="intro">
			<div class="brand">ProductHub.</div>
			<h1>Shape your <span>catalog.</span></h1>
			<p>Create and maintain product records from one clean inventory workspace.</p>
			<a class="back" href="<?= site_url('products') ?>">&larr; Back to products</a>
		</section>
		<div class="panel">
			<div class="eyebrow">ProductHub / Inventory</div>
			<h1><?= htmlspecialchars($heading, ENT_QUOTES, 'UTF-8') ?></h1>

			<?php if ($error): ?>
				<div class="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
			<?php endif; ?>

			<form method="post" action="<?= htmlspecialchars($action, ENT_QUOTES, 'UTF-8') ?>">
				<label for="product_name">Product name</label>
				<input id="product_name" name="product_name" maxlength="100" required value="<?= htmlspecialchars($product['product_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

				<label for="description">Description</label>
				<textarea id="description" name="description"><?= htmlspecialchars($product['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

				<div class="row">
					<div>
						<label for="price">Price (&#8369;)</label>
						<input id="price" type="number" name="price" min="0" step="0.01" required value="<?= htmlspecialchars($product['price'] ?? '0.00', ENT_QUOTES, 'UTF-8') ?>">
					</div>
					<div>
						<label for="quantity">Quantity</label>
						<input id="quantity" type="number" name="quantity" min="0" step="1" required value="<?= htmlspecialchars($product['quantity'] ?? '0', ENT_QUOTES, 'UTF-8') ?>">
					</div>
				</div>

				<div class="buttons">
					<button class="button" type="submit">Save product</button>
					<a class="button secondary" href="<?= site_url('products') ?>">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
