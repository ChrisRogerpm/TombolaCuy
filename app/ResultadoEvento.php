<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultadoEvento extends Model
{
    protected $table = 'resultado_evento';

    protected $primaryKey = 'idResultadosEvento';

    public $timestamps = false;
}
