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
     * @return array
     */
    public function getCategories(): array {
        $rawQuery = "select * from category";
        $query = $this->pdo->prepare($rawQuery);
        $query->execute();
        $categories = [];
        while ($stdClass = $query->fetchObject()) {
            $categories[] = $this->createCategoryModel($stdClass);
        }

        return $categories;
    }

    /**
     * @param stdClass $stdClass
     * @return Category
     */
    private function createCategoryModel(stdClass $stdClass): Category {
        $category = new Category();
        $category->setId((int) $stdClass->id);
        $category->setName($stdClass->name);

        return $category;
    }

}
