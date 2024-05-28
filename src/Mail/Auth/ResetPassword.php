<?php

namespace GohostAuth\Mail\Auth;

use GohostAuth\Mail\BaseMail;

class ResetPassword extends BaseMail
{
    public $activeUrl;

    public $user;

    public $title = 'Cập nhật mật khẩu';

    protected $_contentView = 'gohost-email::auth.reset-password';

    public function __construct($user)
    {
        $this->activeUrl = route('auth.new-password', ['token' => $user->active_token]);
        $this->user = $user;
    }
}
