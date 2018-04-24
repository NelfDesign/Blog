<?= $renderer->render('header'); ?>

    <h1>BIENVENUE SUR LE BLOG !!</h1>
    <ul>
        <li><a href="<?= $router->generateUri('blog.show', ['slug' => 'article-1']); ?>">Article 1</a></li>
        <li>Article 1</li>
        <li>Article 1</li>
        <li>Article 1</li>
        <li>Article 1</li>
        <li>Article 1</li>
    </ul>

<?= $renderer->render('footer'); ?>
