<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class EstadoPagamentosImport implements ToCollection
{
    private Collection $linhas;

    public function __construct()
    {
        $this->linhas = collect();
    }

    public function collection(Collection $collection): void
    {
        $this->linhas = $collection;
    }

    public function linhas(): Collection
    {
        return $this->linhas ?? collect();
    }
}
