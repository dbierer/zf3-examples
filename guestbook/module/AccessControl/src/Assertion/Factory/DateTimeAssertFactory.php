<?php
namespace AccessControl\Assertion\Factory;

use DateTime;
use AccessControl\Assertion\DateTimeAssert;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DateTimeAssertFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = NULL)
    {
        $config = $container->get('access-control-config')['assertions']['date-time-assert-config'];
        $start = new DateTime();
        $start->setTime($config['start']['hour'], $config['start']['minute'], $config['start']['second']);
        $stop = new DateTime();
        $stop->setTime($config['stop']['hour'], $config['start']['minute'], $config['start']['second']);
        $assert = new DateTimeAssert($start, $stop);
        return $assert;
    }
}
