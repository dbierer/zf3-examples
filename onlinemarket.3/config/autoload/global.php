<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'service_manager' => [
        'services' => [
            'market-categories' => [
				'barter',
				'beauty',
				'clothing',
				'computer',
				'entertainment',
				'free',
				'garden',
				'general',
				'health',
				'household',
				'phones',
				'property',
				'sporting',
				'tools',
				'transportation',
				'wanted',
            ],
		    'market-expire-days' => [
		        0  => 'Never',
		        1  => 'Tomorrow',
		        7  => 'Week',
		        30 => 'Month',
		    ],
			'market-captcha-options' => [
		    	'expiration' => 300,
		    	'font'		=> __DIR__ . '/../../data/files/FreeSansBold.ttf',
		    	'fontSize'	=> 24,
		    	'height'	=> 50,
		    	'width'		=> 200,
		    	'imgDir'	=> __DIR__ . '/../../public/captcha',
		    	'imgUrl'	=> '/captcha',
		    ],
        ],
    ],
];
