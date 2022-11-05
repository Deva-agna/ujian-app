<div class="dropdown">
    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
    <div class="dropdown-menu">
        @if($model->ujian->type_ujian == 'essay')
        <a href="{{ route('penilaian.essay', $model->id) }}" class="dropdown-item">
            <i class="fa-solid fa-pen-clip"></i>
            <span>Nilai</span>
        </a>
        @else
        <a href="{{ route('preview.jawaban', $model->id) }}" class="dropdown-item">
            <i class="fa-solid fa-eye"></i>
            <span>Lihat Jawaban</span>
        </a>
        @endif
    </div>
</div>