@props(['status'])

@if ($status)
<div class="alert alert-danger" role="alert">
    <h4 class="alert-heading">
        <i class="fa-solid fa-fw fa-exclamation-triangle"></i>
        Inicio de sesión fallido
    </h4>
    <div class="small">{{ $status }}</div>
</div>
@endif
