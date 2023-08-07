<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken;

class SanctumPersonalAccessClient extends PersonalAccessToken
{
    protected $connection = 'mysql';
    protected $table = 'personal_access_tokens';
}
