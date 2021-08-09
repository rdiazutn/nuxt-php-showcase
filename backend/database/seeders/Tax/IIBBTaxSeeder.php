<?php


namespace Database\Seeders\Tax;


use App\Modules\AFIP\Models\Activities;
use App\Modules\Argentina\Models\Regions;
use App\Modules\Profile\Models\InputType;
use App\Modules\Profile\Models\ProfileQuestion;
use App\Modules\Tax\Models\Tax;
use App\Modules\Tax\Models\TaxPeriodType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IIBBTaxSeeder extends Seeder
{
    public function run()
    {
        $tax = Tax::factory()->default('Ingresos Brutos', 'IIBB', TaxPeriodType::MONTHLY)->create();
        $this->seedProfile($tax);
    }

    private function seedProfile(Model $tax): void
    {
        ProfileQuestion::factory()
            ->hasAttached($tax)
            ->default('¿Qué tipo de contribuyente es?', '', 1, url('/img/tax/que_tipo_de_contribuyente_sos.svg'))
            ->comboBox([
                'local' => 'Local',
                'convenio' => 'Convenio'
            ])
            ->create();
        ProfileQuestion::factory()
            ->hasAttached($tax)
            ->default('¿En qué provincias realiza sus actividades?', '', 2, url('/img/tax/en_que_provincias_realizas_tus_actividades.svg'))
            ->inputMultipleChoice(Regions::asArray(), 'Ingrese el coeficiente de cada provincia')
            ->create();
        ProfileQuestion::factory()
            ->hasAttached($tax)
            ->default('¿Que actividades realiza?', '', 3, url('/img/tax/ingresa_tus_actividades.svg'))
            ->multipleChoice(Activities::all())
            ->create();
    }
}
