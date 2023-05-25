
<form class="d-flex" action="{{ route('history.export') }}" method="post" enctype="multipart/form-data">
  @csrf  
  <div class="d-flex flex-column my-2">
    <button class="btn btn-secondary">
        Exportar historico
    </button>
  </div>
</form>