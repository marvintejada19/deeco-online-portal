<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PopulateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* 'users' table
         */

//---------------------------------------------------------------------------------------------------------------------------------------------------

        DB::table('users')->insert([
            'username'   => 'greg.baes',    'password' => bcrypt('password'), 'role_id' => '2', 'active' => '1']);
        DB::table('users')->insert([
            'username'  => 'jane.doe',      'password' => bcrypt('password'), 'role_id' => '2', 'active' => '1']);

//---------------------------------------------------------------------------------------------------------------------------------------------------

        DB::table('users')->insert([
            'username'   => 'john.doe',   'password' => bcrypt('password'), 'role_id' => '3', 'active' => '1']);
        DB::table('users')->insert([
            'username'   => 'peter.magboo',   'password' => bcrypt('password'), 'role_id' => '3', 'active' => '1']);
        DB::table('users')->insert([
            'username'   => 'shiela.magboo',  'password' => bcrypt('password'), 'role_id' => '3', 'active' => '1']);
        DB::table('users')->insert([
            'username'   => 'perl.gasmen', 'password' => bcrypt('password'), 'role_id' => '3', 'active' => '1']);
        DB::table('users')->insert([
            'username'   => 'avegail.carpio', 'password' => bcrypt('password'), 'role_id' => '3', 'active' => '1']);
        DB::table('users')->insert([
            'username'   => 'richard.chua',   'password' => bcrypt('password'), 'role_id' => '3', 'active' => '1']);

//---------------------------------------------------------------------------------------------------------------------------------------------------
   
        
        DB::table('users')->insert([
            'username' => 'corpuz.emmanuel',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '10',   'lastname' => 'Corpuz',     'firstname' => 'Emmanuel',      'idNumber' => '00-0366', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'cruz.jared',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '11',   'lastname' => 'Cruz',     'firstname' => 'Jared',       'idNumber' => '00-0344', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'cruz.mark',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '12',   'lastname' => 'Cruz',     'firstname' => 'Mark',       'idNumber' => '00-1180', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'enriquez.joshua',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '13',   'lastname' => 'Enriquez',     'firstname' => 'Joshua',       'idNumber' => '00-1075', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'espolong.prince',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '14',   'lastname' => 'Espolong',     'firstname' => 'Prince',       'idNumber' => '00-0268', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'galvez.john',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '15',   'lastname' => 'Galvez',     'firstname' => 'John',       'idNumber' => '00-1411', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'hizon.hadrian',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '16',   'lastname' => 'Hizon',     'firstname' => 'Hadrian',       'idNumber' => '00-0572', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'joaquin.john',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '17',   'lastname' => 'Joaquin',     'firstname' => 'John',       'idNumber' => '00-1122', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'labuguen.viktor',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '18',   'lastname' => 'Labuguen',     'firstname' => 'Viktor',       'idNumber' => '00-0324', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'malibiran.anjelvix',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '19',   'lastname' => 'Malibiran',     'firstname' => 'Anjelvix',       'idNumber' => '00-0384', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'marcelo.janiel',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '20',   'lastname' => 'Marcelo',     'firstname' => 'Janiel',       'idNumber' => '00-1202', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'nierva.james',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '21',   'lastname' => 'Nierva',     'firstname' => 'James',       'idNumber' => '00-0081', 'gender' => '1']);
        
        DB::table('users')->insert([
            'username' => 'roque.gene',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '22',   'lastname' => 'Roque',     'firstname' => 'Gene',       'idNumber' => '00-1004', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'samonte.han',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '23',   'lastname' => 'Samonte',     'firstname' => 'Han',       'idNumber' => '00-0359', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'adano.rhian',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '24',   'lastname' => 'Adano',     'firstname' => 'Rhian',       'idNumber' => '00-1415', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'advincula.claudine',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '25',   'lastname' => 'Advincula',     'firstname' => 'Claudine',       'idNumber' => '00-0791', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'baldado.allysa',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '26',   'lastname' => 'Baldado',     'firstname' => 'Allysa',       'idNumber' => '00-0212', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'chong.samantha',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '27',   'lastname' => 'Chong',     'firstname' => 'Samantha',       'idNumber' => '00-1124', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'flores.maria',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '28',   'lastname' => 'Flores',     'firstname' => 'Maria',       'idNumber' => '00-0210', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'liwanag.danielle',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '29',   'lastname' => 'Liwanag',     'firstname' => 'Danielle',       'idNumber' => '00-1328', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'mallari.erica',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '30',   'lastname' => 'Mallari',     'firstname' => 'Erica',       'idNumber' => '00-1196', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'natividad.kathlene',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '31',   'lastname' => 'Natividad',     'firstname' => 'Kathlene',       'idNumber' => '00-1077', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'ortega.shyra',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '32',   'lastname' => 'Ortega',     'firstname' => 'Shyra',       'idNumber' => '00-0369', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'perez.katie',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '33',   'lastname' => 'Perez',     'firstname' => 'Katie',       'idNumber' => '00-1199', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'quirante.trisha',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '34',   'lastname' => 'Quirante',     'firstname' => 'Trisha',       'idNumber' => '00-0106', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'alberto.jeremy',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '35',   'lastname' => 'Alberto',     'firstname' => 'Jeremy',       'idNumber' => '00-0135', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'carpio.jeremiah',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '36',   'lastname' => 'Carpio',     'firstname' => 'Jeremiah',       'idNumber' => '00-0349', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'cayron.ivan',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '37',   'lastname' => 'Cayron',     'firstname' => 'Ivan',       'idNumber' => '00-1125', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'destecamento.red',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '38',   'lastname' => 'Destecamento',     'firstname' => 'Red',       'idNumber' => '00-0766', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'eustaquio.jigsaw',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '39',   'lastname' => 'Eustaquio',     'firstname' => 'Jigsaw',       'idNumber' => '00-0674', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'go.edil',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '40',   'lastname' => 'Go',     'firstname' => 'Edil',       'idNumber' => '00-1179', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'mapua.dan',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '41',   'lastname' => 'Mapua',     'firstname' => 'Dan',       'idNumber' => '00-0306', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'nebres.mark',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '42',   'lastname' => 'Nebres',     'firstname' => 'Mark',       'idNumber' => '00-1211', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'ong.jamson',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '43',   'lastname' => 'Ong',     'firstname' => 'Jamson',       'idNumber' => '00-0727', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'sabayo.renato',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '44',   'lastname' => 'Sabayo',     'firstname' => 'Renato',       'idNumber' => '00-0197', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'sagle.norking',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '45',   'lastname' => 'Sagle',     'firstname' => 'Norking',       'idNumber' => '00-0659', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'santos.john',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '46',   'lastname' => 'Santos',     'firstname' => 'John',       'idNumber' => '00-1140', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'valerio.patrick',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '47',   'lastname' => 'Valerio',     'firstname' => 'Patrick',       'idNumber' => '00-1163', 'gender' => '1']);

        DB::table('users')->insert([
            'username' => 'besido.rochelle',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '48',   'lastname' => 'Besido',     'firstname' => 'Rochelle',       'idNumber' => '00-0149', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'chu.abigail',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '49',   'lastname' => 'Chu',     'firstname' => 'Abigail',       'idNumber' => '00-0633', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'cruz.michaela',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '50',   'lastname' => 'Cruz',     'firstname' => 'Michaela',       'idNumber' => '00-1067', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'francisco.maria',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '51',   'lastname' => 'Francisco',     'firstname' => 'Maria',       'idNumber' => '00-1127', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'gonzales.kaye',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '52',   'lastname' => 'Gonzales',     'firstname' => 'Kaye',       'idNumber' => '00-0696', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'gonzales.shaira',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '53',   'lastname' => 'Gonzales',     'firstname' => 'Shaira',       'idNumber' => '00-1076', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'mandap.deceryl',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '54',   'lastname' => 'Mandap',     'firstname' => 'Deceryl',       'idNumber' => '00-1097', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'reyes.kate',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '55',   'lastname' => 'Reyes',     'firstname' => 'Kate',       'idNumber' => '00-0241', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'rivera.merilou',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '56',   'lastname' => 'Rivera',     'firstname' => 'Merilou',       'idNumber' => '00-0803', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'ryan.candice',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '57',   'lastname' => 'Ryan',     'firstname' => 'Candice',       'idNumber' => '00-0911', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'sulit.nicole',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '58',   'lastname' => 'Sulit',     'firstname' => 'Nicole',       'idNumber' => '00-0202', 'gender' => '0']);

        DB::table('users')->insert([
            'username' => 'tejada.marvin',     'password' => bcrypt('password'),   'role_id' => '4',   'active' => '1']);
        DB::table('students')->insert([
            'user_id' => '59',   'lastname' => 'Tejada',     'firstname' => 'Marvin',       'idNumber' => '00-1412', 'gender' => '1']);

        /* 'info' tables
         */
        DB::table('school_management')->insert([
            'lastname' => 'Baes', 'firstname' => 'Greg', 'user_id' => '2', 'idNumber' => '01-1234', 'gender' => '1']);
        DB::table('school_management')->insert([
            'lastname' => 'Doe', 'firstname' => 'Jane', 'user_id' => '3', 'idNumber' => '01-2468', 'gender' => '0']);
        //---------------------------------------------------------------------------
        DB::table('faculty')->insert([
            'lastname' => 'Doe', 'firstname' => 'John', 'user_id' => '4', 'idNumber' => '02-2354', 'gender' => '1']);
        DB::table('faculty')->insert([
            'lastname' => 'Magboo', 'firstname' => 'Peter', 'user_id' => '5', 'idNumber' => '02-7498', 'gender' => '1']);
        DB::table('faculty')->insert([
            'lastname' => 'Magboo', 'firstname' => 'Shiela', 'user_id' => '6', 'idNumber' => '02-8159', 'gender' => '0']);
        DB::table('faculty')->insert([
            'lastname' => 'Gasmen', 'firstname' => 'Perl', 'user_id' => '7', 'idNumber' => '02-7123', 'gender' => '0']);
        DB::table('faculty')->insert([
            'lastname' => 'Carpio', 'firstname' => 'Avegail', 'user_id' => '8', 'idNumber' => '02-8352', 'gender' => '0']);
        DB::table('faculty')->insert([
            'lastname' => 'Chua', 'firstname' => 'Richard', 'user_id' => '9', 'idNumber' => '02-5566', 'gender' => '1']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
