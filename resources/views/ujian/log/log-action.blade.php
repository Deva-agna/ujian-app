<div class="dropdown">
    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
    <div class="dropdown-menu">
        <a href="{{ route('log.hasil.ujian', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-eye"></i>
            <span>Lihat Peserta</span>
        </a>
    </div>
</div>