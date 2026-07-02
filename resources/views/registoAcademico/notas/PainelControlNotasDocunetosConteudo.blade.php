<div class="container  col-12">
<div class="card text-left ">

  <div class="card-body">
  <table id="dadTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>{{ $codigo }}</th>
            <th>{{ $local }}</th>
            <th>Nome</th>
            <th>Ac&ccedil;&otilde;es</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($dad))
        @foreach ($dad as $dadItem)


        <tr>
            <td>{{ $dadItem->aluno_classe_id }}</td>
            <td>

                @if($tipoDoc==1000)

                 {{ $dadItem->jurri }}
                @else

                {{ $dadItem->turma }}
                 @endif

            </td>
            <td>{{ $dadItem->nome }}</td>
            <td><button class="badge badge-primary botaoImpeimircertificado"
                data-idaluno="{{$dadItem->aluno_classe_id}}"


                ><i class="fa fa-lg fa-eye" ></i></button></td>
        </tr>
          @endforeach
          @endif
    </tbody>

</table>

  </div>
</div>
</div>



<script>
    $(document).ready(function() {
        $('#dadTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
            },
            pageLength: 5,
            lengthMenu: [5, 10, 25, 50],
            columnDefs: [
                { orderable: false, targets: 3 } // desabilita ordenação na coluna "Ações"
            ]
        });
    });
</script>


