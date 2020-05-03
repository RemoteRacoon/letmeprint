<?php

namespace PrestaShop\Module\MyBlog\Model;

use Category;

class Article extends \ObjectModel
{
    /**
     * @var int
     */
    private $id_blog_article;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $preview;

    /**
     * @var string
     */
    private $content;

    /**
     * @var Category
     */
    private $category;


    public static $definition = [
        'table' => 'ps_blog_article',
        'primary' => 'id_blog_article',
        'fields' => array(
            'title' => ['type' => self::TYPE_STRING, 'lang' => true, 'required' => true, 'size' => 255],
            'preview' => ['type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true, 'size' => 255],
            'content' => ['type' => self::TYPE_HTML, 'validate' => 'isCleanHtml'],
            'category' => ['type' => Category::class]
        ),
    ];


    public function getTitle() : string 
    {
        return $this->title;
    }


    public function setTitle(string $title) : self 
    {
        $this->content = $title;
        
        return $this;
    }


    public function getPreview() : string 
    {
        return $this->preview;
    }


    public function setPreview(string $preview) : self 
    {
        $this->preview = $preview;
        
        return $this;
    }


    public function getContent() : string 
    {
        return $this->content;
    }


    public function setContent(string $content) : self 
    {
        $this->content = $content;
        
        return $this;
    }

    
    public function getCategory()
    {
        return $this->category;
    }


    public function setCategory(Category $category) : self
    {
        $this->category = $category;

        return $this;
    }


    public function toArray()
    {
        return [
            'id_article' => $this->id_article,
            'preview' => $this->preview,
            'content' => $this->content,
            'category' => $this->category
        ];
    }

}