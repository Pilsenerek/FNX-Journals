<article>
    <h2><?php echo $article->getTitle() ?></h2>
    <p><?php echo $article->getShortDescription() ?></p>
    <p><?php echo $article->getContent() ?></p>
    <div class="row">
        <div class="col">
            <strong>Price:</strong> <?php echo number_format($article->getPrice(), 2, ',', ' ') ?>
        </div>
        <div class="col">
            <strong>Category:</strong> <?php echo $article->getCategory() ? $article->getCategory()->getName() : 'Not selected' ?>
        </div>
        <div class="col">
            <strong>Authors:</strong>
            <?php $authors = [] ?>
            <?php foreach ($article->getAuthors() as $author): ?>
                <?php $authors[] = $author->getFullName() ?>
            <?php endforeach ?>
            <?php echo join(', ', $authors) ?>
        </div>
        <div class="col">
            <strong>Tags:</strong>
            <?php $tags = [] ?>
            <?php foreach ($article->getTags() as $tag): ?>
                <?php $tags[] = $tag->getName() ?>
            <?php endforeach ?>
            <?php echo join(', ', $tags) ?>
        </div>
    </div>
</article>



