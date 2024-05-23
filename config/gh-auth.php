<?php

return [
	'token_key' => env('AUTH_TOKEN_KEY', 'auth_token'),
	'auto_create_account' => env('AUTH_AUTO_CREATE_ACCOUNT', false),
	'register_auth_router' => env('AUTH_ENABLE_AUTH_ROUTER', false),
];