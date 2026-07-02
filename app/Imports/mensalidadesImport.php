<?php

namespace App\Imports;

use App\Http\Controllers\registoAcademico\profissaoController;
use App\Models\Admin\observadorSys;
use App\Models\registoAcademico\Aluno;
use App\Models\registoAcademico\alunoClasse;
use App\Models\registoAcademico\anolectivo;
use App\Models\registoAcademico\contacto;
use App\Models\registoAcademico\encaregado;
use App\Models\registoAcademico\endereco;
use App\Models\registoAcademico\grauparentesco;
use App\Models\registoAcademico\mensalidade;
use App\Models\registoAcademico\religiao;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class mensalidadesImport implements ToCollection
{
    /**
     * @param Collection $collection
     */

    protected $dadosrelatorio;
    public function collection(Collection $collection)
    {


for ($x = 2; $x < count($collection); $x++) {

            if (trim($collection[$x][5])== "Pago" and trim($collection[$x][8])!= "") {

               $dados1= mensalidade::where('id',trim($collection[$x][8]))
                    ->where('mes_id',trim($collection[$x][9]))->first();

                 echo($dados1);


                 if(!empty($dados1)){
                   // echo trim($collection[$x][8]);
                    if($dados1->Estado!="Pago"){
                        //dd(Carbon::create(['name' => 'Flight 10']););

                    $unix_timestamp=(($collection[$x][2])-25569)*86400;
                    $data_php =date("Y-m-d",$unix_timestamp);

               $dados = mensalidade::where('id',trim($collection[$x][8]))
                    ->where('mes_id',trim($collection[$x][9]))
                   ->update(['Estado' => 'Pago',
                   'metodo_pagamento_id'=>trim($collection[$x][10]),
                   "Multa"=>trim($collection[$x][7]),
                   'data_pagamento'=>trim($data_php)
                   ]);
                }
            }
                else{
                    echo trim($collection[$x][8]);
                }



            }



 }

    }


}
