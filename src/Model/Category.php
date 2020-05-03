<?php

namespace PrestaShop\Module\MyBlog\Model;

class Category extends \ObjectModel
{
    /**
     * @var int
     */
    private $id_blog_category;

    /**
     * @var string
     */
    private $name;

    
    public function __constructor(string $name)
    {
        $this->setName($name);
    }

    public static $definition = [
        'table' => 'blog_category',
        'primary' => 'id_category',
        'fields' => array(
            'name' => ['type' => self::TYPE_STRING, 'validate' => 'isString'],
        ),
    ];


    public function getName() 
    {
        return $this->name;
    }


    public function setName(string $name)
    {
        $this->name = $name;
        
        return $this;
    }

}