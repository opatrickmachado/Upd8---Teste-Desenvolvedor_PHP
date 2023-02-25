<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class EstadoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Estado::create(['id'=>11,'sigla'=>'RO','estado'=>'Rondônia']);
        Estado::create(['id'=>12,'sigla'=>'AC','estado'=>'Acre']);
        Estado::create(['id'=>13,'sigla'=>'AM','estado'=>'Amazonas']);
        Estado::create(['id'=>14,'sigla'=>'RR','estado'=>'Roraima']);
        Estado::create(['id'=>15,'sigla'=>'PA','estado'=>'Pará']);
        Estado::create(['id'=>16,'sigla'=>'AP','estado'=>'Amapá']);
        Estado::create(['id'=>17,'sigla'=>'TO','estado'=>'Tocantins']);
        Estado::create(['id'=>21,'sigla'=>'MA','estado'=>'Maranhão']);
        Estado::create(['id'=>22,'sigla'=>'PI','estado'=>'Piauí']);
        Estado::create(['id'=>23,'sigla'=>'CE','estado'=>'Ceará']);
        Estado::create(['id'=>24,'sigla'=>'RN','estado'=>'Rio Grande do Norte']);
        Estado::create(['id'=>25,'sigla'=>'PB','estado'=>'Paraíba']);
        Estado::create(['id'=>26,'sigla'=>'PE','estado'=>'Pernambuco']);
        Estado::create(['id'=>27,'sigla'=>'AL','estado'=>'Alagoas']);
        Estado::create(['id'=>28,'sigla'=>'SE','estado'=>'Sergipe']);
        Estado::create(['id'=>29,'sigla'=>'BA','estado'=>'Bahia']);
        Estado::create(['id'=>31,'sigla'=>'MG','estado'=>'Minas Gerais']);
        Estado::create(['id'=>32,'sigla'=>'ES','estado'=>'Espírito Santo']);
        Estado::create(['id'=>33,'sigla'=>'RJ','estado'=>'Rio de Janeiro']);
        Estado::create(['id'=>35,'sigla'=>'SP','estado'=>'São Paulo']);
        Estado::create(['id'=>41,'sigla'=>'PR','estado'=>'Paraná']);
        Estado::create(['id'=>42,'sigla'=>'SC','estado'=>'Santa Catarina']);
        Estado::create(['id'=>43,'sigla'=>'RS','estado'=>'Rio Grande do Sul']);
        Estado::create(['id'=>50,'sigla'=>'MS','estado'=>'Mato Grosso do Sul']);
        Estado::create(['id'=>51,'sigla'=>'MT','estado'=>'Mato Grosso']);
        Estado::create(['id'=>52,'sigla'=>'GO','estado'=>'Goiás']);
        Estado::create(['id'=>53,'sigla'=>'DF','estado'=>'Distrito Federal']);

    }
}
