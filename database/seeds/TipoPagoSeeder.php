<?php

use Illuminate\Database\Seeder;

class TipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::select(DB::raw(
        	"INSERT INTO tipo_pago(idTipoPago ,nombre ,multiplicadorDefecto ,plenoMinimo ,plenoMaximo ,intercalado ,estado) 
        	VALUES (1, 'Pleno',  1.3, 1, 3, 1, 1)")
    	);
    	DB::select(DB::raw(
        	"INSERT INTO tipo_pago(idTipoPago ,nombre ,multiplicadorDefecto ,plenoMinimo ,plenoMaximo ,intercalado ,estado) 
        	VALUES (2, 'Color',  1.4, 1, 3, 1, 1)")
    	);
    	DB::select(DB::raw(
        	"INSERT INTO tipo_pago(idTipoPago ,nombre ,multiplicadorDefecto ,plenoMinimo ,plenoMaximo ,intercalado ,estado) 
        	VALUES (3, 'Par e Impar',  1.5, 1, 3, 1, 1)")
    	);
    	DB::select(DB::raw(
        	"INSERT INTO tipo_pago(idTipoPago ,nombre ,multiplicadorDefecto ,plenoMinimo ,plenoMaximo ,intercalado ,estado) 
        	VALUES (4, '1era, 2da, 3ra ½ docena',  1.1, 1, 3, 1, 1)")
    	);
    	DB::select(DB::raw(
        	"INSERT INTO tipo_pago(idTipoPago ,nombre ,multiplicadorDefecto ,plenoMinimo ,plenoMaximo ,intercalado ,estado) 
        	VALUES (5, 'Del 1 al 12, 13 al 24',  1.2, 1, 3, 1, 1)")
    	);
    	DB::select(DB::raw(
        	"INSERT INTO tipo_pago(idTipoPago ,nombre ,multiplicadorDefecto ,plenoMinimo ,plenoMaximo ,intercalado ,estado) 
        	VALUES (6, 'CajaBoqueda',  1.6, 1, 3, 1, 1)")
    	);
    }
}
