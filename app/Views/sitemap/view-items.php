<?php echo'<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset
    <?= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"' ?>
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <!-- created with Free VIPEmbed Sitemap Generator https://vipembed.com -->

    <!-- Sitemap for movies view pages -->
    <?php if(! empty( $items )): ?>
        <?php foreach($items as $item): ?>

        <url>
            <loc> <?= $item->getViewLink() ?> </loc>
            <lastmod><?= date('c', strtotime( $item->updated_at )); ?></lastmod>
            <priority>0.5</priority>

        </url>

        <?php endforeach; ?>
    <?php endif; ?>

</urlset>
