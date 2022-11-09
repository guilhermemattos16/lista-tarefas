@extends('layout')

@section('content')

  @if(Session::has('success'))
      <div class="alert alert-success">
          {{ Session::get('success') }}
      </div>
  @endif

  <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de Tarefas</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <!-- Trigger the modal with a button -->
                {{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button> --}}
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Nome</th>
                    <th>Custo</th>
                    <th>Data Limite</th>
                    <th>Ordem</th>
                    <th>Ações</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($tarefas as $tarefa)
                  @if ($tarefa->custo >= 1000)
                    <tr style="background:rgba(255,255,0,0.4)">
                  @else
                    <tr>
                  @endif
                      <td style="width: 50%">{{$tarefa->nome}}</td>
                      <td>{{$tarefa->custo}}</td>
                      <td style="width: 10%"> {{ \Carbon\Carbon::parse($tarefa->data)->format('d/m/Y')}} </td>

                      <td style="width: 5%" class="text-center">
                          {{-- {{$tarefa->ordem}}  --}}
                          <div>
                          @if($tarefa->ordem > 1)
                            <form method="POST" action="{{route('sobe', $tarefa)}}">
                              @csrf
                              @method('PUT')
                              <button class="btn btn-xs" type="submit"><i class="fas fa-chevron-up"></i></button>
                            </form>
                          @endif
                          @if($ultimo->ordem != $tarefa->ordem)
                            <form method="POST" action="{{route('desce', $tarefa)}}">
                              @csrf
                              @method('PUT')
                              <button class="btn btn-xs" type="submit"><i class="fas fa-chevron-down"></i></button>
                            </form>
                          @endif
                        </div>
                      </td>

                      <td style="width: 10%">
                        <a href="{{route('edit', $tarefa)}}" class="btn btn-sm btn-primary my-1"><i class="fas fa-pen" ></i></a>
                        <a href="#modalExcluir" class="btn btn-danger btn-sm my-1" data-toggle="modal" id="{{$tarefa->id}}" onclick="alertId(this.id , '{{ route('destroy',$tarefa->id) }}')" data-rota="{{ route('destroy',$tarefa->id) }}"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
                
                <div style="margin-top: 20px" class="float-right">
                  <a type="button" class="btn btn-xg btn-success " href="{{route('create')}}">Incluir Tarefa</a>
                </div>
              </div>
              
            </div>
            
            </div>
          </div>
        </div>
      </div>
    </section>

  <!-- Modal Excluir -->
  <form method="post">
  @csrf
  @method("delete")
    <div id="modalExcluir" class="modal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Excluir Tarefa</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Deseja realmente excluir a tarefa <span id="nome-post"></span>?</p>
              </div>
              <div class="modal-footer">
                  <input type="hidden" name="tarefa_id" id="tarefa_id" value="">
                  <button id="confirmar-delecao" type="submit" class="btn btn-danger">Excluir</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              </div>
          </div>
      </div>
    </div>
    
  </form>
<!-- /Modal Excluir -->

<script>
  $("a").on('click', alertId($(this).attr("id"), 'nome'));
    function alertId(id, nome) {
        var modal = $('#modalExcluir');
        $('#tarefa_id').val(id);
        modal.find('.modal-footer button#confirmar-delecao').attr("formaction",nome);
    }

</script>

@endsection

@section('script')
  
@endsection