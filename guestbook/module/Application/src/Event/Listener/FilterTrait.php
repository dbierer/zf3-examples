<?php
namespace Application\Event\Listener;
use Zend\EventManager\FilterChain;
trait FilterTrait
{
    private $filters = [];

    public function attachFilter($method, callable $listener)
    {
        if (! method_exists($this, $method)) {
            throw new \InvalidArgumentException('Invalid method');
        }
        $this->getFilters($method)->attach($listener);
    }

    public function execute($message)
    {
        return $this->getFilters(__FUNCTION__)
            ->run($this, compact('message'));
    }

    private function getFilters($method)
    {
        if (! isset($this->filters[$method])) {
            $this->filters[$method] = new FilterChain();
        }
        return $this->filters[$method];
    }
}
