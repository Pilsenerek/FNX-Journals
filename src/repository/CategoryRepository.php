<?php
declare(strict_types=1);

namespace App\Repository
;
use App\Model\Category;
use App\RepositoryAbstract;
use stdClass;

/**
 * @author Michal Zbieranek
 */
class CategoryRepository extends RepositoryAbstract {

    /**
     * @param int $id
     * @return Category
     */
    public function getCategoryById(int $id): Category {
        $query = $this->pdo->prepare("select * from category where id=?");
        $query->execute([$id]);
        $category = $this->createCategoryModel($query->fetchObject());

        return $category;
    }

    /**
     * @param stdClass $stdClass
     * @return Category
     */
    private function createCategoryModel(stdClass $stdClass) {
        $category = new Category();
        $category->setName($stdClass->name);

        return $category;
    }

}
