<?php

namespace PrestaShop\Module\MyBlog\Form;

use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;
use PrestaShop\Module\MyBlog\Model\Article;

final class ArticleFormDataProvider implements FormDataProviderInterface
{
    /**
     * @var int|null
     */
    private $idArticle;

    private $repository;

    public function __construct(ArticleRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (null === $this->idArticle) {
            return [];
        }

        $article = new Article($this->idArticle);
        
        // check that the element exists in db
        if (empty($article->id)) {
            throw new PrestaShopObjectNotFoundException('Object not found');
        }

        return ['article' => [
            'title' => $article->getTitle(),
            'preview' => $article->getPreview(),
            'content' => $article->getContent(),
            'category' => $article->getCategory()
        ]];
    }


    public function setData(array $data)
    {
        $article = $data['article'];
        $errors = $this->validateArticle($article);

        if (!empty($erorrs)) {
            return $errors;
        }

        $this->repository->create($article);

    }

    public function getDefaultData()
    {
        return [
            'title' => 'Article Title',
            'preview' => 'Article Preview', 
            'content' => 'Article Content',
            'category' => 'Home'
        ];
    }


     /**
     * @return int
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }


    /**
     * @param int $idLinkBlock
     *
     * @return LinkBlockFormDataProvider
     */
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;

        return $this;
    }


    private function validateArticle(array $article)
    {
        $errors = [];
        
        if (!isset($article['title'])) {
            $errors[] = [
                'key' => 'Missing title'
            ];
        }

        if (!isset($article['preview'])) {
            $errors[] = [
                'key' => 'Missing preview'
            ];
        }

        if (!isset($article['content'])) {
            $errors[] = [
                'key' => 'Missing content'
            ];
        }

        if (!isset($article['category'])) {
            $errors[] = [
                'key' => 'Missing category'
            ];
        }
    }
}