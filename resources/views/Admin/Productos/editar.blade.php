<div class="form-wrapper">
  <div class="page-title">
    <i class="fas fa-box-open icono-label"></i>
    <span>Editar Producto</span>
  </div>
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('admin.productos.actualizar', $producto) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-grid-2cols">
      <div class="form-group custom-file-wrapper-vertical">
        <label for="foto" class="label-foto"><i class="fas fa-image icono-label"></i> Foto</label>
        @if($producto->foto)
          <div class="mb-2">
            <img src="{{ asset('storage/'.$producto->foto) }}" alt="Foto de Producto" style="max-width: 100px; border-radius:50%; margin-top:6px; display:block; margin-left:auto; margin-right:auto;">
          </div>
        @endif
        <input type="file" name="foto" id="foto" class="form-control file-narrow" accept="image/*">
      </div>
      <div>
        <div class="form-group">
          <label for="nombre"><i class="fas fa-box icono-label"></i> Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $producto->nombre }}" required>
        </div>
        <div class="form-group">
          <label for="descripcion"><i class="fas fa-align-left icono-label"></i> Descripción</label>
          <textarea name="descripcion" id="descripcion" class="form-control" rows="2">{{ $producto->descripcion }}</textarea>
        </div>
        <div class="form-group">
          <label for="precio"><i class="fas fa-euro-sign icono-label"></i> Precio (€)</label>
          <input type="number" name="precio" id="precio" class="form-control" step="0.01" min="0" value="{{ $producto->precio }}" required>
        </div>
        <div class="form-group">
          <label for="iva"><i class="fas fa-percent icono-label"></i> IVA (21%)</label>
          <input type="text" name="iva" id="iva" class="form-control" value="{{ number_format($producto->iva,2) }}" readonly>
        </div>
      </div>
    </div>
    <div class="form-group text-right mt-2">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Actualizar Producto
      </button>
    </div>
  </form>
</div>
<script>
// Calcula el IVA automáticamente al escribir el precio
  document.addEventListener('DOMContentLoaded', function() {
    var precioInput = document.getElementById('precio');
    var ivaInput = document.getElementById('iva');
    if(precioInput && ivaInput) {
      precioInput.addEventListener('input', function() {
        var precio = parseFloat(precioInput.value) || 0;
        ivaInput.value = (precio * 0.21).toFixed(2);
      });
    }
  });
</script>
<style>
.form-grid-2cols {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 6px 6px;
}
.form-group {
  margin-bottom: 4px;
}
.form-wrapper {
  background: rgb(236, 236, 236);
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  padding: 8px 8px 8px 8px;
  max-width: 700px;
  margin: 0 auto;
  min-width: 260px;
}
@media (max-width: 991.98px) {
  .form-wrapper {
    max-width: 98vw;
  }
  .form-grid-2cols {
    grid-template-columns: 1fr;
    gap: 4px;
  }
}
@media (max-width: 600px) {
  .form-wrapper {
    padding: 4px 2px 4px 2px;
  }
}
@media (min-width: 1200px) {
  .form-wrapper {
    max-width: 900px;
  }
}
.page-title {
  display: flex;
  align-items: center;
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 6px;
  gap: 8px;
}
.icono-label {
  color: #27ae60;
  margin-right: 4px;
}
.btn-accion-modal {
  border-radius: 8px;
  min-width: 120px;
  padding-left: 1rem;
  padding-right: 1rem;
}
.form-group label, .nowrap-label {
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: 1rem;
}
.form-group input, .form-group select, .form-group textarea {
  border-radius: 8px;
  border: 1px solid #ccc;
  width: 100%;
  box-sizing: border-box;
}
.custom-file-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 2px;
}
input[type="file"] {
  width: auto !important;
  min-width: 0 !important;
  max-width: 220px !important;
  display: inline-block !important;
  margin: 0 auto 0 auto !important;
  background: #fff !important;
  color: #333 !important;
  font-size: 0.98rem;
  padding: 2px 4px;
  border-radius: 8px;
  border: 1px solid #ccc;
  vertical-align: middle;
}
.file-narrow {
  width: 160px !important;
  min-width: 0 !important;
  max-width: 180px !important;
  display: inline-block !important;
  margin: 0 auto 0 auto !important;
  background: #fff !important;
  color: #333 !important;
  font-size: 0.98rem;
  padding: 2px 4px;
  border-radius: 8px;
  border: 1px solid #ccc;
  vertical-align: middle;
}
.custom-file-wrapper-vertical {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  min-height: 220px;
}
.label-foto {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  margin-bottom: 8px;
  font-size: 1.05rem;
}
@media (max-width: 991.98px) {
  .custom-file-wrapper-vertical {
    min-height: 120px;
  }
}
</style>
