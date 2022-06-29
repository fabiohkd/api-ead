<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    use HasFactory;

		protected $fillable = [
			'lesson_id',
			'user_id',
			'qty'
		];

		public function user()
		{
			$this->belongsTo(User::class);
		}

		public function lesson()
		{
			$this->belongsTo(Lesson::class);
		}
}
