<?php

namespace App\Cart;

use App\Cart\Contracts\CartInterface;
use Illuminate\Session\SessionManager;

class Cart implements CartInterface
{
    protected $session;

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    public function create()
    {
        dd($this->session);
    }

}
