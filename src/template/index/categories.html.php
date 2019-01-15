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
            <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category->getName() ?></td>
                    <td class="text-center">
                        <a title="View articles from this category" href="?&category_id=<?php echo $category->getId() ?>">
                            <span class="fa fa-list"></span>
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>

    </table>
</div>

