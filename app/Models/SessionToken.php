<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionToken extends Model
{
    protected $connection = 'ts3';
	public $timestamps    = false;
	protected $primaryKey = 'id';
	protected $table      = 'auth.user_session_token';
	
}