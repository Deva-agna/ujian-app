<div class="dropdown">
    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('mapel.edit', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>Edit</span>
        </a>
        <form id="form-delete{{$model->id}}" action="{{route('mapel.destroy', $model->slug)}}" method="post">
            @method('delete')
            @csrf
            <button class="btn-hapus dropdown-item" data-id="{{$model->id}}" style="background-color: transparent;">
                <i class="fa-solid fa-trash-can"></i>
                <span>Hapus</span>
            </button>
        </form>
    </div>
</div>