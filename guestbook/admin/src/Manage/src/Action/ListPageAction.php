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

class ListPageAction implements ServerMiddlewareInterface
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

        $params  = $request->getQueryParams();
        $id      = $params['id'] ?? FALSE;
        $confirm = $params['confirm'] ?? FALSE;
        
        $data['routerName']   = 'Zend Router';
        $data['routerDocs']   = 'https://docs.zendframework.com/zend-router/';
        $data['templateName'] = 'Twig';
        $data['templateDocs'] = 'http://twig.sensiolabs.org/documentation';
        $data['response']     = $request->getParsedBody();
        $data['id']           = $id;
        $data['ok_corall']    = $confirm;
         
        return new HtmlResponse($this->template->render('manage::list-page', $data));
    }
}
