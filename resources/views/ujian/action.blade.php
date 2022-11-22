<?php date_default_timezone_set("Asia/Jakarta"); ?>
<div class="dropdown">
    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow" data-toggle="dropdown">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </button>
    <div class="dropdown-menu">
        @if($model->status == 'pending')
        @if($model->type_ujian == "pg")
        <a href="{{ route('soal.pg.list', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-file-pen"></i>
            <span>Kelola Soal</span>
        </a>
        @elseif($model->type_ujian == "mc")
        <a href="{{ route('soal.mc.list', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-file-pen"></i>
            <span>Kelola Soal</span>
        </a>
        @else
        <a href="{{ route('soal.essay.list', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-file-pen"></i>
            <span>Kelola Soal</span>
        </a>
        @endif
        <a href="{{ route('ujian.edit', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-pen-to-square"></i>
            <span>Edit</span>
        </a>
        @endif
        @if($model->detailUjian->count() == 0)
        <form id="form-delete{{$model->id}}" action="{{route('ujian.destroy', $model->slug)}}" method="post">
            @method('delete')
            @csrf
            <button class="btn-hapus dropdown-item" data-id="{{$model->id}}" style="background-color: transparent;">
                <i class="fa-solid fa-trash-can"></i>
                <span>Hapus</span>
            </button>
        </form>
        @endif

        @if($model->status == 'pending' && $model->detailUjian->count() >= 5 && ($model->type_ujian == 'pg' || $model->type_ujian == 'mc'))
        <div>
            <form id="form-delete{{$model->id}}" action="{{route('ujian.update.status')}}" method="post">
                @method('patch')
                @csrf
                <input type="hidden" name="slug" value="{{$model->slug}}">
                <input type="hidden" name="status" value="active">
                <button class="btn-active dropdown-item" data-id="{{$model->id}}" style="background-color: transparent;">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Active</span>
                </button>
            </form>
        </div>
        @endif

        @if($model->status == 'active' && time() > strtotime($model->waktu_mulai))
        <a href="{{ route('lihat.peserta', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-eye"></i>
            <span>Lihat Peserta</span>
        </a>
        <a href="{{ route('lihat.soal', $model->slug) }}" class="dropdown-item">
            <i class="fa-solid fa-list"></i>
            <span>Lihat Soal</span>
        </a>
        @endif

        @if($model->status == 'pending' && $model->detailUjian->count() >= 1 && $model->type_ujian == 'essay')
        <form id="form-delete{{$model->id}}" action="{{route('ujian.update.status')}}" method="post">
            @method('patch')
            @csrf
            <input type="hidden" name="slug" value="{{$model->slug}}">
            <input type="hidden" name="status" value="active">
            <button class="btn-active dropdown-item" data-id="{{$model->id}}" style="background-color: transparent;">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <span>Active</span>
            </button>
        </form>
        @endif


        @if($model->status == 'active' && strtotime($model->waktu_mulai) > time())
        <div>
            <form id="form-cancelled{{$model->id}}" action="{{route('ujian.update.status')}}" method="post">
                @method('patch')
                @csrf
                <input type="hidden" name="slug" value="{{$model->slug}}">
                <input type="hidden" name="status" value="pending">
                <button class="btn-cancelled dropdown-item" data-id="{{$model->id}}" style="background-color: transparent;">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Cancelled</span>
                </button>
            </form>
        </div>
        @endif

        @if($model->status == 'active' && strtotime($model->waktu_selesai) < time()) <div>
            <form id="form-completed{{$model->id}}" action="{{route('ujian.selesai')}}" method="post">
                @csrf
                <input type="hidden" name="slug" value="{{$model->slug}}">
                <input type="hidden" name="status" value="completed">
                <button class="btn-completed dropdown-item" data-id="{{$model->id}}" style="background-color: transparent;">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Tutup Ujian</span>
                </button>
            </form>
    </div>
    @endif

</div>
</div>