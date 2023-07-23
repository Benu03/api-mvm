<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeyAuth extends Model
{
    protected $connection = 'ts3';
	public $timestamps    = false;
	protected $primaryKey = 'id';
	protected $table      = 'mst.mst_general';
	
}