<?php
namespace AccessControl\Acl\Factory;

use DateTime;
use AccessControl\Acl\GuestbookAcl;
use Interop\Container\ContainerInterface;
use Zend\Permissions\Acl\Acl;
use Zend\ServiceManager\Factory\FactoryInterface;

class GuestbookAclFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $config = $container->get('access-control-config');
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
        foreach ($config['resources'] as $resource => $class) {
            $acl->addResource($resource);
        }
        // assign rights
        foreach ($config['rights'] as $role => $assignment) {
            foreach ($assignment as $resource => $rights) {
                if (isset($rights['allow'])) {
                    if (isset($rights['assert'])) {
                        $acl->allow($role, $resource, $rights['allow'], $container->get($rights['assert']));
                    } else {
                        $acl->allow($role, $resource, $rights['allow']);
                    }
                }
                if (isset($rights['deny'])) {
                    if (isset($rights['assert'])) {
                        $acl->deny($role, $resource, $rights['allow'], $container->get($rights['assert']));
                    } else {
                        $acl->deny($role, $resource, $rights['allow']);
                    }
                }
            }
        }
        return $acl;
    }
}
