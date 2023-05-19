<form class="d-flex" action="{{ route('taush.import') }}" method="post" enctype="multipart/form-data">
  @csrf  
  <div class="d-flex flex-column my-2">
    <input type="file" name="file" class="form-control" required>
    <button class="btn btn-secondary">
      Carregar CSV
    </button>
  </div>
</form>