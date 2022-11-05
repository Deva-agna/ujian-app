<div class="dropdown">
    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('tahun.ajaran.edit', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>Edit</span>
        </a>
        @if(!$model->status)
        <form id="form-active{{$model->id}}" action="{{route('tahun.ajaran.active', $model->slug)}}" method="post">
            @method('patch')
            @csrf
            <button class="btn-active dropdown-item" data-id="{{$model->id}}" style="background-color: transparent;">
                <i class="fa-solid fa-toggle-on"></i>
                <span>Aktivkan</span>
            </button>
        </form>
        <form id="form-delete{{$model->id}}" action="{{route('tahun.ajaran.destroy', $model->slug)}}" method="post">
            @method('delete')
            @csrf
            <button class="btn-hapus dropdown-item" data-id="{{$model->id}}" style="background-color: transparent;">
                <i class="fa-solid fa-trash-can"></i>
                <span>Hapus</span>
            </button>
        </form>
        @endif
    </div>
</div>