<?php
/**
 * Created by PhpStorm.
 * User: Luis Mejia
 * Date: 3/29/2015
 * Time: 6:25 PM
 */

Use \Illuminate\Database\Seeder;
Use \Illuminate\Support\Facades\DB;
Use \Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder{

    public function run()
    {
        DB::table('tipousuario')->insert(array(

            'nombre' => 'Estudiante',
            'activo' => true

        ));

        DB::table('tipousuario')->insert(array(

            'nombre' => 'Empleado',
            'activo' => true
        ));

        DB::table('tipousuario')->insert(array(

            'nombre' => 'Docente',
            'activo' => true
        ));

        DB::table('categorias')->insert(array(

            'nombre' => 'Cuerda',
            'activo' => true
        ));

        DB::table('categorias')->insert(array(

            'nombre' => 'Viento',
            'activo' => true
        ));

        DB::table('categorias')->insert(array(

            'nombre' => 'Percusión',
            'activo' => true
        ));

        DB::table('categorias')->insert(array(

            'nombre' => 'Disfraces',
            'activo' => true
        ));


        DB::table('estadoarticulo')->insert(array(

            'nombre' => 'Excelente',
            'activo' => true
        ));

        DB::table('estadoarticulo')->insert(array(

            'nombre' => 'Defectuoso',
            'activo' => true
        ));

        DB::table('users')->insert(array(

			'nombres' => 'Luis Alberto',
            'apellidos' => 'Mejia Arroyave',
            'tipoUsuario' => 3,
            'habilitado' => true,
            'email' => 'mejialuis28@gmail.com',
			'documento' => '1037607728',
			'password' => Hash::make('lucho28')
        ));

        DB::table('users')->insert(array(

            'nombres' => 'Carlos Arturo',
            'apellidos' => 'Botero Gallego',
            'tipoUsuario' => 1,
            'habilitado' => true,
            'email' => 'boterocarlosarturo@gmail.com',
            'documento' => '43530242',
            'password' => Hash::make('carlos')
        ));

        DB::table('users')->insert(array(

            'nombres' => 'Juan Felipe',
            'apellidos' => 'Londono Arbelaez',
            'tipoUsuario' => 2,
            'habilitado' => true,
            'email' => 'piplondona@gmail.com',
            'documento' => '8163143',
            'password' => Hash::make('felipe')
        ));
    }
}