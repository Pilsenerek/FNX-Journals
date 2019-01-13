<article>
    <h2><?php echo $article->getTitle() ?></h2>
    <p><?php echo $article->getShortDescription() ?></p>
    <p><?php echo $article->getContent() ?></p>
    <div class="row">
        <div class="col">
            <strong>Price:</strong> <?php echo number_format($article->getPrice(), 2, ',', ' ') ?>
        </div>
        <div class="col">
            <strong>Category:</strong>
            <?php if($article->getCategory()): ?>
                <a href="/?category_id=<?php echo $article->getCategory()->getId() ?>"><?php echo $article->getCategory()->getName() ?></a>
            <?php else: ?>
                Not selected
            <?php endif ?>
        </div>
        <div class="col">
            <strong>Authors:</strong>
            <?php $authors = [] ?>
            <?php foreach ($article->getAuthors() as $author): ?>
                <?php $authors[] = '<a href="/?author_id='.$author->getId().'">'.$author->getFullName().'</a>' ?>
            <?php endforeach ?>
            <?php echo join(', ', $authors) ?>
        </div>
        <div class="col">
            <strong>Tags:</strong>
            <?php $tags = [] ?>
            <?php foreach ($article->getTags() as $tag): ?>
                <?php $tags[] = '<a href="/?tag_id='.$tag->getId().'">'.$tag->getName().'</a>' ?>
            <?php endforeach ?>
            <?php echo join(', ', $tags) ?>
        </div>
    </div>
</article>



