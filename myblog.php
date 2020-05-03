<?php



if (!defined('_PS_VERSION_')) {
    exit;
}

if (file_exists(__DIR__. '/vendor/autoload.php')) {
    require_once __DIR__. '/vendor/autoload.php';
}

use PrestaShop\Module\MyBlog\Install\MyBlogInstaller;

class MyBlog extends Module 
{

    public function __construct()
    {
        $this->name = 'myblog';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Vladimir Litvintsev';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Prestashop articles module');
        $this->description = $this->l('Provides the latest data about the world');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

        if (!Configuration::get('MYMODULE_NAME')) {
            $this->warning = $this->l('No name provided');
        }
    }

    public function install()
    {
        $installer = new MyBlogInstaller();

        return parent::install() && $installer->install();
    }

    public function uninstall()
    {
        $installer = new MyBlogInstaller();

        return parent::uninstall() && installer()->uninstall();
    }
}