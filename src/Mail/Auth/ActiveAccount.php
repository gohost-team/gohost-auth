<?php

namespace GohostAuth\Mail\Auth;

use GohostAuth\Mail\BaseMail;

class ActiveAccount extends BaseMail
{
    public $activeUrl;

    public $user;

    public $title = 'Kích hoạt tài khoản';

    protected $_contentView = 'gohost-email::auth.active-account';

    public function __construct($user)
    {
        $this->activeUrl = route('auth.new_password', ['token' => $user->active_token]);
        $this->user = $user;
    }
}
