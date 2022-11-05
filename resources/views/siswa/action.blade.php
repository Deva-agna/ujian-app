<div class="dropdown">
    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('reset.password.siswa', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-rotate"></i>
            <span>Reset Password</span>
        </a>
        <a href="{{ route('siswa.edit', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>Edit</span>
        </a>
        <form id="form-delete{{$model->id}}" action="{{route('siswa.destroy', $model->slug)}}" method="post">
            @method('delete')
            @csrf
            <button class="btn-hapus dropdown-item" data-id="{{$model->id}}" style="background-color: transparent;">
                <i class="fa-solid fa-trash-can"></i>
                <span>Hapus</span>
            </button>
        </form>
    </div>
</div>