<?php

// You can find the keys here : https://apps.twitter.com/

return [
	'debug'               => function_exists('env') ? env('APP_DEBUG', false) : false,

	'API_URL'             => 'api.twitter.com',
	'UPLOAD_URL'          => 'upload.twitter.com',
	'API_VERSION'         => '1.1',
	'AUTHENTICATE_URL'    => 'https://api.twitter.com/oauth/authenticate',
	'AUTHORIZE_URL'       => 'https://api.twitter.com/oauth/authorize',
	'ACCESS_TOKEN_URL'    => 'https://api.twitter.com/oauth/access_token',
	'REQUEST_TOKEN_URL'   => 'https://api.twitter.com/oauth/request_token',
	'USE_SSL'             => true,

	'CONSUMER_KEY'        => function_exists('env') ? env('TWITTER_CONSUMER_KEY', '0ugFsXlrSxt1CcJBRGtDDLBy0') : '0ugFsXlrSxt1CcJBRGtDDLBy0',
	'CONSUMER_SECRET'     => function_exists('env') ? env('TWITTER_CONSUMER_SECRET', 'zkW6YLIqEWHzCThLhwj5JCxEQxgMNPoN1SXn3Fgy4H17uCut7G') : 'zkW6YLIqEWHzCThLhwj5JCxEQxgMNPoN1SXn3Fgy4H17uCut7G',
	'ACCESS_TOKEN'        => function_exists('env') ? env('TWITTER_ACCESS_TOKEN', '576221686-O0vh1Es3MSqNdaxRQTuVHZD7BxDkClByuxrNmM7R') : '576221686-O0vh1Es3MSqNdaxRQTuVHZD7BxDkClByuxrNmM7R',
	'ACCESS_TOKEN_SECRET' => function_exists('env') ? env('TWITTER_ACCESS_TOKEN_SECRET', 'bhNKslaFOSwS37nNeHyrbNZs0Rk5VUVqxJK9RZDKwvsVC') : 'bhNKslaFOSwS37nNeHyrbNZs0Rk5VUVqxJK9RZDKwvsVC',
];
