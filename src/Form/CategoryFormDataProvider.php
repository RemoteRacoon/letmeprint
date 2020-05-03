<?php

namespace PrestaShop\Module\MyBlog\Form;

use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;
use PrestaShop\Module\MyBlog\Model\Category;

final class CategoryFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var int|null
     */
    private $idCategory;

    /**
     * @return array
     */
    public function getData()
    {
        if (null === $this->idCategory) {
            return [];
        }

        $category = new Category($this->idCategory);
        
        // check that the element exists in db
        if (empty($category->id)) {
            throw new PrestaShopObjectNotFoundException('Object not found');
        }

        return ['category' => [
            'name' => $category->getName()
        ]];
    }


    public function setData(array $data)
    {
        $article = $data['category'];
        $errors = $this->validateCategory($article);

        if (!empty($erorrs)) {
            return $errors;
        }

        $this->repository->create($article);

    }

    public function getDefaultData()
    {
        return [
            'name' => 'Category name',
        ];
    }


     /**
     * @return int
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }


    /**
     * @param int $idLinkBlock
     *
     * @return LinkBlockFormDataProvider
     */
    public function setIdCategory($idCategory)
    {
        $this->idCategory = $idCategory;

        return $this;
    }


    private function validateCategory(array $category)
    {
        $errors = [];
        
        if (!isset($category['name'])) {
            $errors[] = [
                'key' => 'Missing category name'
            ];
        }
    }
}