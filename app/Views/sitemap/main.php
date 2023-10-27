<?php echo'<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset
    <?= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' ?>
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <!-- created with Free VIPEmbed Sitemap Generator https://vipembed.com -->

    <!-- home page-->
    <url>
        <loc><?= site_url() ?></loc>
        <priority>1.0</priority>
        <changefreq>daily</changefreq>
    </url>

    <!-- API page -->
    <url>
        <loc><?= site_url('/api') ?></loc>
        <priority>0.8</priority>
        <changefreq>monthly</changefreq>
    </url>

    <!-- Contact us page -->
    <url>
        <loc><?= site_url('/contact-us') ?></loc>
        <priority>0.8</priority>
        <changefreq>monthly</changefreq>
    </url>

    <?php if(is_users_system_enabled()): ?>

    <!-- Earn money page -->
    <url>
        <loc><?= site_url('/earn-money') ?></loc>
        <priority>0.8</priority>
        <changefreq>monthly</changefreq>
    </url>

    <!-- Login page -->
    <url>
        <loc><?= site_url('/login') ?></loc>
        <priority>0.8</priority>
        <changefreq>monthly</changefreq>
    </url>

    <!-- Register page -->
    <url>
        <loc><?= site_url('/register') ?></loc>
        <priority>0.8</priority>
        <changefreq>monthly</changefreq>
    </url>

    <?php endif ?>

    <!-- main pages-->
    <?php foreach($dailyUpdates as $page): ?>

        <url>
            <loc><?= $page ?></loc>
            <priority>0.8</priority>
            <changefreq>daily</changefreq>
        </url>

    <?php endforeach; ?>

</urlset>
