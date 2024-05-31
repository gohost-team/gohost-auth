<?php

return [
	'token_key' => 'token', // Don't change this key, it used by jwt
	'auto_create_account' => env('AUTH_AUTO_CREATE_ACCOUNT', false),
	'register_auth_router' => env('AUTH_ENABLE_AUTH_ROUTER', false),
	'base_url' => env('AUTH_BASE_URL', 'http://localhost:8080'),	
	'home_url' => env('AUTH_HOME_URL', 'http://localhost:8080'),	
	'user_model' => '\App\Models\User',
];