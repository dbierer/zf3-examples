<?php
namespace Application\Event\Filter;
use Zend\EventManager\Filter\FilterIterator;
class MaskCcnum
{
    const CCNUM_REGEX = '!(\d{3,4})-(\d{3,4})-(\d{3,4})-(\d{3,4})!';
    public function filter ($context, array $argv, FilterIterator $chain)
    {
        $message = isset($argv['message']) ? $argv['message'] : '';
        $message = preg_replace(self::CCNUM_REGEX, 'xxxx-xxxx-xxxx-$4');
        $filtered = $chain->next($context, ['message' => $message], $chain);
        return $filtered;
    }
}
