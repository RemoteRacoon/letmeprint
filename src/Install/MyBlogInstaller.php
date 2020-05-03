<?php

namespace PrestaShop\Module\MyBlog\Install;

use Db;

class MyBlogInstaller
{
    const MODULE_PREFIX = 'blog_';

    private $tableNames = [
        'article_tag',
        'comment',
        'category',
        'article',
        'tag',
    ];

    public function __construct()
    {

    }


    public function install() : bool
    {
        return $this->installDB();
    }


    public function uninstall() : bool 
    {
        return $this->uninstallDB();
    }


    private function installDB()
    {
        $queries[] = '
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.self::MODULE_PREFIX.'category` (
            `id_category` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(64) NOT NULL,
            PRIMARY KEY (`id_category`)
        ) DEFAULT CHARSET=utf8 ;
        ';

        $queries[] = '
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.self::MODULE_PREFIX.'article` (
            `id_article` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `preview` VARCHAR(128) NOT NULL,
            `content` text NOT NULL ,
            `category_id` INT UNSIGNED NOT NULL,
            FOREIGN KEY (`category_id`)
                REFERENCES `'._DB_PREFIX_.self::MODULE_PREFIX.'category`(`id_category`)
                ON DELETE CASCADE,
            `created_at` TIMESTAMP DEFAULT NOW() ON UPDATE NOW(),
            `updated_at` TIMESTAMP DEFAULT NOW() ON UPDATE NOW(),
            PRIMARY KEY (`id_article`)
        ) DEFAULT CHARSET=utf8;
        ';

        $queries[] = '
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.self::MODULE_PREFIX.'tag` (
            `id_tag` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(64) NOT NULL,
            PRIMARY KEY (`id_tag`)
        ) DEFAULT CHARSET=utf8;
        ';

        $queries[] = '
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.self::MODULE_PREFIX.'article_tag` (
            `id_article` INT UNSIGNED  NOT NULL,
            FOREIGN KEY (`id_article`)
                REFERENCES `'._DB_PREFIX_.self::MODULE_PREFIX.'article`(`id_article`)
                ON DELETE CASCADE,
            `id_tag` INT UNSIGNED NOT NULL,
            FOREIGN KEY (`id_tag`)
                REFERENCES `'._DB_PREFIX_.self::MODULE_PREFIX.'tag`(`id_tag`)
                ON DELETE CASCADE
        ) DEFAULT CHARSET=utf8;
        ';

        $queries[] = '
        CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.self::MODULE_PREFIX.'comment` (
            `id_comment` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `comment` VARCHAR(1024) NOT NULL,
            `id_article` INT UNSIGNED NOT NULL,
            PRIMARY KEY (`id_comment`),
            FOREIGN KEY (`id_article`)
                REFERENCES `' ._DB_PREFIX_.self::MODULE_PREFIX.'article`(`id_article`)
                ON DELETE CASCADE,
            `created_at` TIMESTAMP DEFAULT NOW() ON UPDATE NOW(),
            `updated_at` TIMESTAMP DEFAULT NOW() ON UPDATE NOW()
        ) DEFAULT CHARSET=utf8;
        ';

        return $this->executeQueries($queries);
    }

    
    private function uninstallDB()
    {
        $queries = [];

        foreach ($this->tableNames as $table) {
            $queries[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.self::MODULE_PREFIX.$table.'`;';
        }
        
        return $this->executeQueries($queries);
    }
    
    private function executeQueries(array $queries) : bool
    {
        foreach ($queries as $query)
        {
            if (!Db::getInstance()->execute($query)) {
                return false;
            }
        }

        return true;
    }
}