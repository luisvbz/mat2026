<?php

namespace Database\Seeders;

use App\Models\Anio;
use App\Models\AnioEscolar;
use App\Models\Configuracion;
use App\Models\Costo;
use App\Models\CronogramaPagos;
use App\Models\Grado;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
        \Spatie\Permission\Models\Role::create(['name' => 'Operador']);
        \Spatie\Permission\Models\Role::create(['name' => 'Tesorero']);


        $admin = User::create([
            'name' => 'Super Administrador',
            'email' => 'master@iepdivinosalvador.net.pe',
            'username' => 'master',
            'email_verified_at' => now(),
            'password' => bcrypt('Lui$2210_'),
        ]);

        $yuxne = User::create([
            'name' => 'Yuxneidy Nava',
            'username' => 'ycns10',
            'email' => 'ynava@iepdivinosalvador.net.pe',
            'email_verified_at' => now(),
            'password' => bcrypt('29811212_'),
        ]);

        $maria = User::create([
            'name' => 'Maria Alcalde',
            'username' => 'maryalcalde',
            'email' => 'malcalde@iepdivinosalvador.net.pe',
            'email_verified_at' => now(),
            'password' => bcrypt('laura042020.'),
        ]);

        $brenda = User::create([
            'name' => 'Brenda Querevalú',
            'username' => 'brendaquerevalu',
            'email' => 'bquerevalu@iepdivinosalvador.net.pe',
            'email_verified_at' => now(),
            'password' => bcrypt('brenda2020.'),
        ]);


        $admin->assignRole([1]);
        $yuxne->assignRole([1]);
        $maria->assignRole([2]);
        $brenda->assignRole([2]);


        Configuracion::create([
            'key' => 'sms_cobro_previo',
            'valor' => 1,
            'type' => 'bool',
            'descripcion' => 'Notificación previa por sms'
        ]);

        Configuracion::create([
            'key' => 'sms_pago_vencido',
            'valor' => 1,
            'type' => 'bool',
            'descripcion' => 'Notificación por pago vencido'
        ]);

        Configuracion::create([
            'key' => 'matricula_activa',
            'valor' => 1,
            'type' => 'bool',
            'descripcion' => 'Mostrar  el formulario de matricula'
        ]);

        Configuracion::create([
            'key' => 'email_moroso',
            'valor' => 1,
            'type' => 'bool',
            'descripcion' => 'Enviar correos electronico cuando la persona esta morosa'
        ]);

        Configuracion::create([
            'key' => 'sms_token',
            'valor' => 'demo',
            'type' => 'string',
            'descripcion' => 'Token de sms Gamanet'
        ]);

        Configuracion::create([
            'key' => 'prefijo_matricula',
            'valor' => 'IEPDS',
            'type' => 'string',
            'descripcion' => 'Prefijo para el registro de la matricula'
        ]);


        Configuracion::create([
            'key' => 'anio_actual',
            'valor' => '2021',
            'type' => 'string',
            'descripcion' => 'Año de la matricula'
        ]);

        Configuracion::create([
            'key' => 'porcentaje_mora',
            'valor' => '0.015',
            'type' => 'string',
            'descripcion' => 'Porcentaje de Mora por día'
        ]);


        Anio::create([
            'anio' => 2021,
            'estado' => true,
            'titulo' => 'Nuevo año escolar'
        ]);

        Grado::insert([
        [
            'nivel' => 'P',
            'numero' => 1,
            'nombre' => 'Primero'
        ],
        [
            'nivel' => 'P',
            'numero' => 2,
            'nombre' => 'Segundo'
        ],
        [
            'nivel' => 'P',
            'numero' => 3,
            'nombre' => 'Tercero'
        ],
        [
            'nivel' => 'P',
            'numero' => 4,
            'nombre' => 'Cuarto'
        ],
        [
            'nivel' => 'P',
            'numero' => 5,
            'nombre' => 'Quinto'
        ],
        [
            'nivel' => 'P',
            'numero' => 6,
            'nombre' => 'Sexto'
        ],
        [
        'nivel' => 'S',
            'numero' => 1,
            'nombre' => 'Primero'
        ],
        [
            'nivel' => 'S',
            'numero' => 2,
            'nombre' => 'Segundo'
        ],
        [
            'nivel' => 'S',
            'numero' => 3,
            'nombre' => 'Tercero'
        ],
        [
            'nivel' => 'S',
            'numero' => 4,
            'nombre' => 'Cuarto'
        ],
        [
            'nivel' => 'S',
            'numero' => 5,
            'nombre' => 'Quinto'
        ]]);

        Costo::insert([
            [
                'tipo' => 'Presencial',
                'alias' => 'presencial',
                'costo' => 350.00
            ],
            [
                'tipo' => 'Semi Presencial',
                'alias' => 'semi-presencial',
                'costo' => 330.00
            ],
            [
                'tipo' => 'Virtual',
                'alias' => 'virtual',
                'costo' => 250.00
            ]
        ]);

        CronogramaPagos::insert([
           [
               'orden' => 1,
               'orden_letras' => 'PRIMERA',
               'mes' => '03',
               'costo_id' => 3,
               'costo' => 250.00,
               'fecha_inicio' => '2021-03-01',
               'fecha_vencimiento' => '2021-03-31',
           ],
           [
                'orden' => 2,
                'orden_letras' => 'SEGUNDA',
                'mes' => '04',
                'costo_id' => 3,
                'costo' => 250.00,
                'fecha_inicio' => '2021-04-01',
                'fecha_vencimiento' => '2021-04-30',
           ],
           [
                'orden' => 3,
                'orden_letras' => 'TERCERA',
                'mes' => '05',
                'costo_id' => 3,
                'costo' => 250.00,
                'fecha_inicio' => '2021-05-01',
                'fecha_vencimiento' => '2021-05-31',
           ],
           [
                'orden' => 4,
                'orden_letras' => 'CUARTA',
                'mes' => '06',
                'costo_id' => 3,
                'costo' => 250.00,
                'fecha_inicio' => '2021-06-01',
                'fecha_vencimiento' => '2021-06-30',
           ],
           [
                'orden' => 5,
                'orden_letras' => 'QUINTA',
                'mes' => '07',
                'costo_id' => 3,
                'costo' => 250.00,
                'fecha_inicio' => '2021-07-01',
                'fecha_vencimiento' => '2021-07-31',
           ],
           [
                'orden' => 6,
                'orden_letras' => 'SEXTA',
                'mes' => '08',
                'costo_id' => 3,
                'costo' => 250.00,
                'fecha_inicio' => '2021-08-01',
                'fecha_vencimiento' => '2021-08-31',
           ],
           [
                'orden' => 7,
                'orden_letras' => 'SEPTIMA',
                'mes' => '09',
                'costo_id' => 3,
                'costo' => 250.00,
                'fecha_inicio' => '2021-09-01',
                'fecha_vencimiento' => '2021-09-30',
           ],
           [
                'orden' => 8,
                'orden_letras' => 'OCTAVA',
                'mes' => '10',
                'costo_id' => 3,
                'costo' => 250.00,
                'fecha_inicio' => '2021-10-01',
                'fecha_vencimiento' => '2021-10-31',
           ],
           [
                'orden' => 9,
                'orden_letras' => 'NOVENA',
                'mes' => '11',
                'costo_id' => 3,
                'costo' => 250.00,
                'fecha_inicio' => '2021-11-01',
                'fecha_vencimiento' => '2021-11-30',
           ],
            [
                'orden' => 10,
                'orden_letras' => 'DECIMA',
                'mes' => '12',
                'costo_id' => 3,
                'costo' => 250.00,
                'fecha_inicio' => '2021-12-01',
                'fecha_vencimiento' => '2021-12-22',
            ],
        ]);
    }
}
