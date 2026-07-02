@if (is_object($disp))

    <style>
        /* Versão monocromática - apenas tons de cinza */
        .nav-tabs .nav-link {
            background-color: #f1f3f5;  /* Cinza claro para inativas */
            color: #495057;
            border: 1px solid #ced4da;
            margin-right: 5px;
            transition: all 0.2s ease;
        }

        .nav-tabs .nav-link:hover {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }

        .nav-tabs .nav-link.active {
            background-color: #ffffff !important;  /* Branco puro para ativa */
            color: #212529 !important;              /* Preto para texto */
            border: 1px solid #ced4da;
            border-bottom: 2px solid #495057;       /* Destaque cinza escuro */
            font-weight: 600;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.05);
        }
    </style>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        @foreach ($disp as $key => $disItem)


                    <li class="nav-item" role="presentation">
                        <a class="nav-link disciplina_id @if ($key === 0) active @endif"
                           id="tab-{{ $disItem->disciplina->id }}"
                           href="#{{ $disItem->disciplina->id }}tab"
                           role="tab"
                           aria-controls="{{ $disItem->disciplina->id }}tab"
                           aria-selected="{{ $key === 0 ? 'true' : 'false' }}"
                           data-toggle="tab"
                           data-disciplina-id="{{ $disItem->disciplina->id }}"
                           title="{{ $disItem->disciplina->Descricao }}">
                            {{ $disItem->disciplina->Descricao }}
                        </a>
                    </li>

        @endforeach
    </ul>
@endif
