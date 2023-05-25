<br>
@if (session('taushMessage'))
   {{ session('taushMessage') }}                          
@endif
<br>
@if (session('pickingMessage'))                     
   {{ session('pickingMessage') }}
@endif
<br>
@if (session('digitalizedMessage'))                     
   {{ session('digitalizedMessage') }}
@endif
<form class="d-flex" action="{{ route('history.create') }}" method="post" enctype="multipart/form-data">
  @csrf  
  <div class="d-flex flex-column my-2">
    <input type="text" name="reference" class="form-control" required>
    <button class="btn btn-secondary">
        Criar historico
    </button>
  </div>
</form>
