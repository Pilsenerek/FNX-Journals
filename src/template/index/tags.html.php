<h2>Tags list</h2>

<div class="col-md-4">
    <table class="table table-striped table-hover table-sorted table-bordered">
        <thead class="active">
            <tr>
                <th class="text-center align-middle">Name</th>
                <th class="text-center align-middle">Popularity</th>
                <th class="text-center align-middle">Action</th>
            </tr>    
        </thead>
        <tbody>
            <?php foreach ($tags as $tag): ?>
                <tr>
                    <td><?php echo $tag->getName() ?></td>
                    <td class="text-right"><?php echo $tag->getNumberOfArticles() ?></td>
                    <td class="text-center">
                        <a title="View articles from this tag" href="?tag_id=<?php echo $tag->getId() ?>">
                            <span class="fa fa-list"></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>

