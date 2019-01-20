<h2>Author <?php echo $author->getFullName() ?> details</h2>

<?php if (!empty($author->getAbout())): ?>
    <h3>About this author</h3>
    <p><?php echo $author->getAbout() ?></p>
<?php endif ?>

<h3>Articles written by <?php echo $author->getFullName() ?></h3>
<table class="table table-striped table-hover table-sorted table-bordered">
    <thead class="active">
        <tr>
            <th class="text-center align-middle">Title</th>
            <th class="text-center align-middle">Price</th>
            <th class="text-center align-middle">Description</th>
            <th class="text-center align-middle">Action</th>
        </tr>     
    </thead>
    <tbody>
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><?php echo $article->getTitle() ?></td>
                <td class="text-right"><?php echo number_format($article->getPrice(), 2, ',', ' ') ?></td>
                <td><?php echo $article->getShortDescription() ?></td>
                <td class="text-center"><a title="View this article" href="?a=article&id=<?php echo $article->getId() ?>"><span class="fa fa-eye"></span></a></td>
            </tr>
        <?php endforeach ?>
    </tbody>

</table>

