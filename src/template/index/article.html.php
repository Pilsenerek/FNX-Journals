<article>
    <h2><?php echo $article->getTitle() ?></h2>
    <p><?php echo $article->getShortDescription() ?></p>
    <?php if ($article->isFree() or $_user->hasArticle($article)): ?>
        <p><?php echo $article->getContent() ?></p>
    <?php else: ?>  
        <?php if ($_user->canAfford($article)): ?>
            <p>
                <a 
                    href="/?a=buy&article_id=<?php echo $article->getId() ?>&url_back=<?php echo urlencode('/?a=article&id=' . $article->getId()) ?>"
                    class="btn btn-primary btn-lg"
                    role="button"
                    aria-pressed="true"
                    >
                    <span class="fa fa-cart-plus"></span> Buy this article
                </a>
                Your wallet will be <?php echo number_format($_user->getWallet() - $article->getPrice(), 2, ',', ' ') ?> after that
            </p>
        <?php else: ?>    
            <p>
                <a href="#" class="btn btn-primary btn-lg disabled" role="button" aria-pressed="true">
                    <span class="fa fa-cart-plus"></span> Buy this article
                </a>
                Insufficient cash!
            </p>
        <?php endif ?>
    <?php endif ?>

    <div class="row">
        <div class="col">
            <strong>Price:</strong> <?php echo number_format($article->getPrice(), 2, ',', ' ') ?>
        </div>
        <div class="col">
            <strong>Category:</strong>
            <?php if ($article->getCategory()): ?>
                <a href="/?category_id=<?php echo $article->getCategory()->getId() ?>"><?php echo $article->getCategory()->getName() ?></a>
            <?php else: ?>
                Not selected
            <?php endif ?>
        </div>
        <div class="col">
            <strong>Authors:</strong>
            <?php $authors = [] ?>
            <?php foreach ($article->getAuthors() as $author): ?>
                <?php $authors[] = '<a href="/?a=authorDetail&author_id=' . $author->getId() . '">' . $author->getFullName() . '</a>' ?>
            <?php endforeach ?>
            <?php echo join(', ', $authors) ?>
        </div>
        <div class="col">
            <strong>Tags:</strong>
            <?php $tags = [] ?>
            <?php foreach ($article->getTags() as $tag): ?>
                <?php $tags[] = '<a href="/?tag_id=' . $tag->getId() . '">' . $tag->getName() . '</a>' ?>
            <?php endforeach ?>
            <?php echo join(', ', $tags) ?>
        </div>
    </div>
</article>



