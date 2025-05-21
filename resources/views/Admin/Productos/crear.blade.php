<div class="form-wrapper">
  <div class="page-title">
    <i class="fas fa-plus-circle"></i>
    <span>Crear Producto</span>
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
  <form action="{{ route('admin.productos.guardar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-grid-1col">
      <div class="form-group">
        <label for="nombre"><i class="fas fa-box icono-label"></i> Nombre</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="descripcion"><i class="fas fa-align-left icono-label"></i> Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control" rows="3" style="resize:vertical; min-height:60px; max-height:180px;"></textarea>
      </div>
      <div class="form-group">
        <label for="precio"><i class="fas fa-euro-sign icono-label"></i> Precio (€)</label>
        <input type="number" name="precio" id="precio" class="form-control" step="0.01" min="0" required>
      </div>
      <div class="form-group">
        <label for="iva"><i class="fas fa-percent icono-label"></i> IVA (21%)</label>
        <input type="text" name="iva" id="iva" class="form-control" value="0.00" readonly>
      </div>
      <div class="form-group">
        <label for="foto"><i class="fas fa-image icono-label"></i> Foto</label>
        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
      </div>
    </div>
    <div class="form-group text-right mt-2">
      <button type="submit" class="btn btn-success btn-accion-modal">
        <i class="fas fa-check"></i> Crear Producto
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
.form-grid-1col {
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.form-group {
  margin-bottom: 4px;
}
.form-wrapper {
  background: rgb(236, 236, 236);
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  padding: 8px 8px 8px 8px;
  max-width: 420px;
  margin: 0 auto;
  min-width: 220px;
}
@media (max-width: 991.98px) {
  .form-wrapper {
    max-width: 98vw;
  }
}
@media (max-width: 600px) {
  .form-wrapper {
    padding: 4px 2px 4px 2px;
  }
}
@media (min-width: 1200px) {
  .form-wrapper {
    max-width: 500px;
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
</style>
