<?php
namespace AccessControl\Acl\Factory;

use Interop\Container\ContainerInterface;
use Zend\Permissions\Acl\Acl;
use Zend\ServiceManager\Factory\FactoryInterface;

class GuestbookAclFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $config = $container->get('access-control-config');
        $resources = $config['resources'];
        $acl = new Acl();
        // add roles w/ inheritance
        foreach ($config['roles'] as $role => $inherits) {
            if ($inherits) {
                $acl->addRole($role, $inherits);
            } else {
                $acl->addRole($role);
            }
        }
        // add resources
        foreach ($resources as $key => $class) {
            $acl->addResource($class);
        }
        // assign rights
        foreach ($config['rights'] as $role => $assignment) {
            foreach ($assignment as $key => $rights) {
                if (array_key_exists('allow', $rights)) {
                    $assert = (isset($rights['assert'])) ? $container->get($rights['assert']) : NULL;
                    $acl->allow($role, $resources[$key], $rights['allow'], $assert);
                }
                if (array_key_exists('deny', $rights)) {
                    $assert = (isset($rights['assert'])) ? $container->get($rights['assert']) : NULL;
                    $acl->allow($role, $resources[$key], $rights['deny'], $assert);
                }
            }
        }
        return $acl;
    }
}
