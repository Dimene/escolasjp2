
<?php
$conf = DB::table('config')->first();
$host = request()->getHost();
$subdomain = explode('.', $host)[0];
?>

<div style="text-align: center; margin-top: 10px;">
    <div style="display: inline-block; height: 60px; width: 60px; border-radius: 60px; overflow: hidden;">
        <img src="<?php echo e(asset('storage/'.$subdomain.'/logoMarca/'.$conf->avatar)); ?>"
             style="width: 100%; height: 100%; object-fit: cover; border-radius: 60px;">
    </div>

    <div style="margin-top: 10px;">
        <h4><strong><?php echo e($conf->nome); ?></strong></h4>
    </div>
</div>
<?php /**PATH C:\laragon\www\escolasaojoaopaulo\resources\views/Componetes/cabecalho.blade.php ENDPATH**/ ?>