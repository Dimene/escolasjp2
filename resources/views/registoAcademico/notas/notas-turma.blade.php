<div class="form-group">

    <label>
{{ ($anolectivo->anomodelo->Descricao ) }}
    </label>
    @if (is_object($anolectivo))
        <select id="my-select" class="form-control" name="divisao_aolectivo">
            @foreach ($anolectivo->modalidadeDivisao as $Itemanodivisao)

{{-- @if( $divisaoestado->where("id", $Itemanodivisao->id )->first()->Estado2==1) --}}
                <option value="{{ $Itemanodivisao->id }}">{{ $Itemanodivisao->divisao }}
                    {{ $anolectivo->anomodelo->Descricao }}</option>
                    {{-- @endif --}}
            @endforeach
        </select>
</div>
@else
@endif
