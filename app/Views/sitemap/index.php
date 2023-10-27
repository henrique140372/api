<?php echo'<?xml version="1.0" encoding="UTF-8"?>' ?>

<?php echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' ?>
    <!-- created with Free VIPEmbed Sitemap Generator https://vipembed.com -->
    <?php if(! empty($urls)): ?>
        <?php foreach ($urls as $url) : ?>

        <sitemap>
            <loc><?= esc( $url ) ?></loc>
        </sitemap>

        <?php endforeach; ?>
    <?php endif; ?>

<?php echo '</sitemapindex>' ?>