<?php

namespace App\Library;

class UserResponse
{
    public $status;
    public $message;
    public $user;

    public function __construct($s, $m, $user = null)
    {
        $this->status = $s;
        $this->message = $m;
        $this->user = $user;
    }

}
