<h2>Categories list</h2>

<div class="col-md-4">
    <table class="table table-striped table-hover table-sorted table-bordered">
        <thead class="active">
            <tr>
                <th class="text-center align-middle">Name</th>
                <th class="text-center align-middle">Action</th>
            </tr>    
        </thead>
        <tbody>
            <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?php echo $author->getFullName() ?></td>
                    <td class="text-center">
                        <a title="View articles from this author" href="?&author_id=<?php echo $author->getId() ?>">
                            <span class="fa fa-list"></span>
                        </a>
                        <a title="View author details" href="?a=authorDetail&author_id=<?php echo $author->getId() ?>">
                            <span class="fa fa-eye"></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>

