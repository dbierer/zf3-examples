<?php
namespace Manage\Service;

use Zend\Db\TableGateway\TableGateway;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

class Guestbook implements MiddlewareInterface
{
    protected $table;
    public function setTable(TableGateway $table)
    {
        $this->table = $table;
    }
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $data    = $action = [];
        $params  = $request->getQueryParams();
        $id      = $params['id'] ?? FALSE;
        $del     = $params['del'] ?? FALSE;
        $confirm = $params['confirm'] ?? FALSE;
        if ($id) {
            if ($confirm && $del) {
                $this->table->delete(['id' => (int) $id]);
            } else {
                $data = $this->table->select(['id' => (int) $id])->toArray();
                $action = ['id' => $id, 'confirm' => 1];
            }
        }
        $data = $data ?: $this->table->select()->toArray();
        return $delegate->process($request);
    }
}
