<?php

// ==================================================
// AUTH
// ==================================================

if (! function_exists('login_url')) 
{
    function login_url()
    {
        return config('gh-auth.base_url')."/login";
    }
}

if (! function_exists('logout_url')) 
{
    function logout_url()
    {
        return config('gh-auth.base_url')."/logout";
    }
}

if (! function_exists('home_url')) 
{
    function home_url()
    {
        return config('gh-auth.home_url');
    }
}