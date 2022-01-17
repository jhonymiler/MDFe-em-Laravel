<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
	public static function getCidadeCod($codMun)
	{
		return Cidade::where('codigo', $codMun)
			->first();
	}

	public static function getId($id)
	{
		return Cidade::where('id', $id)
			->first();
	}
}
