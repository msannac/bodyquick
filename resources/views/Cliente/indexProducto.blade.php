<h2 class="mb-4"><i class="fas fa-store"></i> Productos</h2>
<div class="row">
  @foreach($productos as $producto)
    <div class="col-12 col-md-4 mb-4">
      <div class="card small-card">
        <div class="circle-img-wrapper">
          @if($producto->foto)
            <img src="{{ asset('storage/' . $producto->foto) }}" class="card-img-top" alt="{{ $producto->nombre }}">
          @else
            <img src="{{ asset('images/producto-default.png') }}" class="card-img-top" alt="{{ $producto->nombre }}">
          @endif
        </div>
        <div class="card-body text-center p-2">
          <h6 class="card-title mb-1">{{ $producto->nombre }}</h6>
          <p class="card-text mb-2">{{ $producto->descripcion }}</p>
          <p class="card-text mb-2">Precio: <strong>{{ number_format($producto->precio, 2) }} €</strong></p>
          <p class="card-text mb-2">IVA (21%): <strong>{{ number_format($producto->iva, 2) }} €</strong></p>
        </div>
      </div>
    </div>
  @endforeach
</div>
<style>
  .card {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border: none;
  }
  .small-card {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border: none;
    border-radius: 15px;
    overflow: hidden;
    padding-top: 8px;
    padding-bottom: 8px;
    min-height: 270px;
    background: rgb(236, 236, 236);
  }
  .card-title {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }
  .card-text {
    font-size: 0.9rem;
  }
  .card-img-top {
    width: 94px;
    height: 94px;
    object-fit: cover;
    background-color: #fff;
    border-radius: 50%;
    margin: 0;
    display: block;
    border: none;
    box-shadow: none;
    position: static;
  }
  .circle-img-wrapper {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #fff;
    margin: 12px auto 8px auto;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 2px solid #e0e0e0;
    position: relative;
    z-index: 1;
    overflow: hidden;
  }
</style>
