<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Course extends Model
{
    use HasFactory, UuidTrait, HasApiTokens;

		public $incrementing = false;
		protected $keyType = 'uuid';

		protected $fillable =	[
			'name',
			'description',
			'image',
		];
}