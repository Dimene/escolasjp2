<?php
// app/Http/Controllers/AlunoExportController.php

namespace App\Http\Controllers;

use App\Exports\AlunoCadastroExport;
use App\Models\Aluno;
use App\Models\AnoLectivo;
use App\Models\Classe;
use App\Models\Religiao;
use App\Models\Profissao;
use App\Models\GrauParentesco;
use App\Models\TabelaValoresAno;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AlunoExportController extends Controller
{
    /**
     * Exportar ficha de um aluno específico
     */
    public function exportarFichaAluno($id)
    {
        // Buscar dados do aluno
        $aluno = Aluno::with(['anoLectivo', 'classe', 'religiao', 'pagamentos'])->findOrFail($id);

        // Preparar dados formatados
        $dadosAluno = [
            'escola_nome' => config('app.name', 'Escola'),
            'ano_lectivo_nome' => $aluno->anoLectivo->anolectivo ?? null,
            'classe_nome' => $aluno->classe->Descricao ?? null,
            'nome_aluno' => $aluno->nome_aluno,
            'data_nascimento' => $aluno->data_nascimento ? $aluno->data_nascimento->format('d/m/Y') : null,
            'sexo_aluno' => $aluno->sexo_aluno,
            'religiao_nome' => $aluno->religiao->nome ?? null,
            'bairro' => $aluno->bairro,
            'rua_avenida' => $aluno->rua_avenida,
            'quarteirao' => $aluno->quarteirao,
            'casa_numero' => $aluno->casa_numero,
            'naturalidade' => $aluno->naturalidade,
            'provincia' => $aluno->provincia,
            'pais' => $aluno->pais ?? 'Moçambique',
            'estado_saude' => $aluno->estado_saude,
            'doencas' => json_decode($aluno->doencas, true) ?? [],
            'nome_pai' => $aluno->nome_pai,
            'profissao_pai' => $aluno->profissao_pai,
            'nome_mae' => $aluno->nome_mae,
            'profissao_mae' => $aluno->profissao_mae,
            'nome_encarregado' => $aluno->nome_encarregado,
            'sexo_encarregado' => $aluno->sexo_encarregado,
            'grau_parentesco_nome' => $aluno->grauParentesco->Descricao ?? null,
            'profissao_encarregado' => $aluno->profissao_encarregado,
            'contacto' => json_decode($aluno->contacto, true) ?? [],
            'pagamentos' => $this->formatarPagamentos($aluno->pagamentos ?? [])
        ];

        // Dados básicos para selects
        $anolectivo = AnoLectivo::all();
        $classes = Classe::all();
        $religiao = Religiao::all();
        $profissao = Profissao::all();
        $grauparentesco = GrauParentesco::all();
        $tabelavaloresano = TabelaValoresAno::all();

        // Criar exportação
        $export = new AlunoCadastroExport($dadosAluno);
        $export->setDadosBasicos($anolectivo, $classes, $religiao, $profissao, $grauparentesco, $tabelavaloresano);

        // Gerar nome do arquivo
        $nomeArquivo = 'ficha_' . str_replace(' ', '_', $aluno->nome_aluno) . '_' . date('Y-m-d') . '.xlsx';

        // Baixar arquivo
        return Excel::download($export, $nomeArquivo);
    }

    /**
     * Exportar ficha em branco para preenchimento
     */
    public function exportarFichaEmBranco()
    {
        $dadosAluno = []; // Array vazio para ficha em branco

        $anolectivo = AnoLectivo::all();
        $classes = Classe::all();
        $religiao = Religiao::all();
        $profissao = Profissao::all();
        $grauparentesco = GrauParentesco::all();
        $tabelavaloresano = TabelaValoresAno::all();

        $export = new AlunoCadastroExport($dadosAluno);
        $export->setDadosBasicos($anolectivo, $classes, $religiao, $profissao, $grauparentesco, $tabelavaloresano);

        return Excel::download($export, 'ficha_cadastro_em_branco_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Exportar lista de alunos (múltiplos)
     */
    public function exportarListaAlunos(Request $request)
    {
        // Buscar alunos com filtros opcionais
        $query = Aluno::with(['anoLectivo', 'classe']);

        if ($request->filled('classe')) {
            $query->where('classe_id', $request->classe);
        }

        if ($request->filled('ano_lectivo')) {
            $query->where('ano_lectivo_id', $request->ano_lectivo);
        }

        $alunos = $query->get();

        // Aqui você pode criar uma exportação em lista
        // Vamos usar múltiplas sheets
        return Excel::download(new class($alunos) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets {
            protected $alunos;

            public function __construct($alunos)
            {
                $this->alunos = $alunos;
            }

            public function sheets(): array
            {
                $sheets = [];

                // Primeira sheet: resumo
                $sheets[] = new class($this->alunos) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithTitle {
                    protected $alunos;

                    public function __construct($alunos)
                    {
                        $this->alunos = $alunos;
                    }

                    public function view(): View
                    {
                        return view('exports.lista-alunos-resumo', ['alunos' => $this->alunos]);
                    }

                    public function title(): string
                    {
                        return 'Resumo de Alunos';
                    }
                };

                // Sheets individuais para cada aluno
                foreach ($this->alunos as $index => $aluno) {
                    $sheets[] = new class($aluno, $index) implements \Maatwebsite\Excel\Concerns\FromView, \Maatwebsite\Excel\Concerns\WithTitle {
                        protected $aluno;
                        protected $index;

                        public function __construct($aluno, $index)
                        {
                            $this->aluno = $aluno;
                            $this->index = $index;
                        }

                        public function view(): View
                        {
                            return view('exports.aluno-individual', ['aluno' => $this->aluno]);
                        }

                        public function title(): string
                        {
                            return 'Aluno ' . ($this->index + 1);
                        }
                    };
                }

                return $sheets;
            }
        }, 'lista_alunos_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Formatar pagamentos para exportação
     */
    private function formatarPagamentos($pagamentos)
    {
        $formatados = [];

        foreach ($pagamentos as $pagamento) {
            $formatados[] = [
                'finalidade' => $pagamento->finalidade ?? 'Mensalidade',
                'valor' => $pagamento->valor ?? 0,
                'parcelas' => $pagamento->parcelas ?? 1,
                'status' => $pagamento->status ?? 'Pendente'
            ];
        }

        return $formatados;
    }
}
