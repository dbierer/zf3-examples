<?php
namespace Application\Event\Listener;
class ErrorLogWithFilter extends ErrorLog
{
    use FilterTrait;
}
