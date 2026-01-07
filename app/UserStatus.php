<?php

namespace App;

enum UserStatus: string
{
    case WAITING = 'waiting';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';

    public static function loginMessage($status) {
        switch($status){
            case UserStatus::WAITING:
                return 'Login Failed, Your Account has not been approved by the Admin.';
        }
    }

}
