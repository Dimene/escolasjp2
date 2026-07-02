
@php
$conf = DB::table('config')->first();
$host = request()->getHost();
$subdomain = explode('.', $host)[0];
@endphp

<div style="text-align: center; margin-top: 10px;">
    <div style="display: inline-block; height: 60px; width: 60px; border-radius: 60px; overflow: hidden;">
        <img src="{{ asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar) }}"
             style="width: 100%; height: 100%; object-fit: cover; border-radius: 60px;">
    </div>

    <div style="margin-top: 10px;">
        <h4><strong>{{ $conf->nome }}</strong></h4>
    </div>
</div>
