<?php


if(! function_exists('get_admin_id'))
{
    function get_admin_id(): int
    {
        return 1;
    }
}

if(! function_exists('get_admin_user'))
{
    function get_admin_user()
    {
        return service('auth')->getAdminUser();
    }
}


if(! function_exists('current_user'))
{
    function current_user()
    {
        return \App\Libraries\Authentication::getLoggedUser();
    }
}

if(! function_exists('get_current_user_id'))
{
    function get_current_user_id(): int
    {
        return current_user()->id;
    }
}

if(! function_exists('is_logged'))
{
    function is_logged(): bool
    {
        return  \App\Libraries\Authentication::isLogged();
    }
}

if(! function_exists('is_admin'))
{
    function is_admin(): bool
    {
        return  current_user()->isAdmin();
    }
}

if(! function_exists('is_user'))
{
    function is_user(): bool
    {
        return  current_user()->isUser();
    }
}

if(! function_exists('get_admin_user_info'))
{
    function get_admin_user_info($key = null)
    {
        $user = model('UserModel')->getUser( get_admin_id() );
        if($user !== null){
            if($key !== null){
                if(! empty($user->{$key})){
                    return $user->{$key};
                }
            }

            return $user;
        }

        return null;
    }
}