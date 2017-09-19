<?php
namespace Manage;

use PDO;
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'services' => [
                'db-config' => [
                    'driver' => 'pdo_mysql',
                    'dsn' => 'mysql:host=localhost;dbname=course',
                    'username' => 'vagrant',
                    'password' => 'vagrant',
                    'options' => [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
                ]
            ],
            'factories'  => [
                Action\AdminPageAction::class => Action\AdminPageFactory::class,
                Action\ListPageAction::class => Action\ListPageFactory::class,
                Service\Guestbook::class => Service\GuestbookFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'manage'    => [__DIR__ . '/../templates/manage'],
            ],
        ];
    }
}
