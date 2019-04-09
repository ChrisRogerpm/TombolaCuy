<?php

use App\Usuario;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=4;$i<=2000;$i++){
            $usuario = new Usuario();
            $usuario->usuario = 'test.cajero'.$i;
            $usuario->perfil_id = 0;
            $usuario->password = bcrypt('cajero.test');            
            $usuario->fecha_registro = now();
            $usuario->save();
        }
    }
}
