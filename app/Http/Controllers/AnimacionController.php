<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\TipoApuesta;
class AnimacionController extends Controller
{
    public function AnimacionVista()
    {
    	$listaTipoApuesta=TipoApuesta::TipoApuestaListarJson();
    	foreach($listaTipoApuesta as $TipoApuesta){
    		if($TipoApuesta->idTipoApuesta==37){
    			$color1=$TipoApuesta->rgb;
    		}
    		if($TipoApuesta->idTipoApuesta==38){
    			$color2=$TipoApuesta->rgb;
    		}
    		 if($TipoApuesta->idTipoApuesta==39){
    			$color0=$TipoApuesta->rgb;
    		}
    	}
        return view('Animacion.AnimacionVista', compact("color1","color2","color0"));
    }    
}
