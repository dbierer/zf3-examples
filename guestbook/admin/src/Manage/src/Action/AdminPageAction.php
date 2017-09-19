<?php
namespace Manage\Action;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface as ServerMiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Uri;
use Zend\Diactoros\Response\ {HtmlResponse, JsonResponse};
use Zend\Expressive\ {Router, Template};
use Zend\Expressive\Twig\TwigRenderer;
use Zend\Expressive\ZendView\ZendViewRenderer;

class AdminPageAction implements ServerMiddlewareInterface
{
    private $router;
    private $template;

    public function __construct(Router\RouterInterface $router, Template\TemplateRendererInterface $template = null)
    {
        $this->router   = $router;
        $this->template = $template;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        
        if (! $this->template) {
            return new JsonResponse([
                'welcome' => 'Congratulations! You have installed the zend-expressive skeleton application.',
                'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
            ]);
        }

        $params = $request->getQueryParams();
        $id = $params['id'] ?? NULL;
        if ($id) {
            return $delegate->process($request->withQueryParams($params));
        } else {
            return $delegate->process($request);
        }

    }
}
