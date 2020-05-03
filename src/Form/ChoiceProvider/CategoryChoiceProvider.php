<?php


namespace PrestaShop\Module\MyBlog\Form\ChoiceProvider;

use Doctrine\DBAL\Connection;
use PrestaShop\PrestaShop\Core\Foundation\Database\EntityNotFoundException;
use PrestaShop\PrestaShop\Core\Form\FormChoiceProviderInterface;

final class CategoryChoiceProvider implements FormChoiceProviderInterface
{
    const MODULE_PREFIX = 'blog_';

    private $connection;
    private $dbPrefix;

    public function __construct(
        Connection $connection,
        $dbPrefix
    )
    {
        $this->connection = $connection;
        $this->dbPrefix = $dbPrefix;
    }


    public function getChoices()
    {
        $choices = [];
        $qb = $this->connection->createQueryBuilder();

        $qb->select('c.id_category, c.name')->from($this->dbPrefix.self::MODULE_PREFIX . 'category');

        return $choices;
    }

}