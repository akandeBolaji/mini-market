<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    public function markets()
	{
		return $this->hasMany(Market::class);
    }
}
