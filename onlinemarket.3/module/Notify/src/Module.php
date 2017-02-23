<?php
namespace Notify;

use Zend\EventManager\EventInterface;
use Zend\Mvc\MvcEvent;
use Zend\Mail\Message;
use Zend\Mail\Transport\ {Sendmail, Smtp, SmtpOptions, File, FileOptions};

class Module
{

    const EVENT_NOTIFY = 'notify.event';
    const TRANSPORT_KEY_PREFIX = 'notify-transport-';
    const DEFAULT_TRANSPORT = 'file';
    const DEFAULT_SUBJECT = 'A Notification Event Occurred';
    const DEFAULT_BODY = 'A Notification Event Occurred';

    protected $serviceManager;

    public function onBootstrap(MvcEvent $e)
    {
        // this stores a reference to the Service Manager
        // for use by any listeners defined in this class
        $this->serviceManager = $e->getApplication()->getServiceManager();
        $sem = $e->getApplication()->getEventManager()->getSharedManager();
        $sem->attach('*', self::EVENT_NOTIFY, [$this, 'sendEmail'], 99);
    }
    public function sendEmail(EventInterface $e)
    {
        // init vars
        $params = $e->getParams();
        $message = $this->serviceManager->get('notify-message');
        $settings = $this->serviceManager->get('notify-email-settings');
        $transKey = self::TRANSPORT_KEY_PREFIX . ($settings['transport'] ?? self::DEFAULT_TRANSPORT);
        $transport = $this->serviceManager->get($transKey);
        // setup message and send
        $message->addTo($settings['to']);
        $message->addFrom($settings['from']);
        $message->setSubject($params['subject']);
        $body = $params['body'] ?? self::DEFAULT_BODY;
        $message->setBody($body);
        $transport->send($message);
    }
    public function getServiceConfig()
    {
        return [
            // override these in /config/autoload/notify.local.php
            'services' => [
                'notify-email-settings' => [
                    'to' => 'info@example.com',
                    'from' => 'info@example.com',
                    'transport' => 'file',          // can be: sendmail | smtp | file
                ],
                'notify-transport-settings' => [
                    'file' => [
                        'path' => __DIR__ . '/../../../data/mail',
                    ],
                    'smtp' => [
                        'name'              => 'localhost.localdomain',
                        'host'              => '127.0.0.1',
                        'connection_class'  => 'plain',
                        'connection_config' => [
                            'username' => 'user',
                            'password' => 'pass',
                        ],
                    ],
                    // 'sendmail' => [],   // no options for sendmail
                ],
            ],
            'factories' => [
                'notify-transport-sendmail' => function ($sm) {
                    return new SendMail();
                },
                'notify-transport-smtp' => function ($sm) {
                    return new Smtp(new SmtpOptions($sm->get('notify-transport-settings')['sendmail']));
                },
                'notify-transport-file' => function ($sm) {
                    return new File(new FileOptions($sm->get('notify-transport-settings')['file']));
                },
                'notify-message' => function ($sm) {
                    return new Message();
                },
            ],
        ];
    }
}
