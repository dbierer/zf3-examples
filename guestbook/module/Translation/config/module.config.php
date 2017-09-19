<?php
namespace Translation;
use Locale;
use Zend\I18n\Translator\TranslatorServiceFactory;
return [
    'translator' => [
        //'locale' => Locale::getDefault(),
        'locale' => 'fr',
        'translation_file_patterns' => [
            /*
            [
                'type'     => 'ini',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.ini',
            ],
            */
            [
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
        'factories' => [
            'MvcTranslator' => TranslatorServiceFactory::class,
        ],
    ],
    'listeners' => [
        Listener\TranslationListenerAggregate::class,
    ],
];
