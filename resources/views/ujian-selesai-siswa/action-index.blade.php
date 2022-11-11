@if($model->nilai->count())
@if($model->type_ujian == 'essay')
<a href="{{ route('preview.jawaban.essay.siswa', $model->nilai[0]->id) }}" class="btn btn-icon btn-icon rounded-circle btn-success waves-effect waves-float waves-light">
    <i class="fa-regular fa-eye"></i>
</a>
@else
<a href="{{ route('preview.jawaban.siswa', $model->nilai[0]->id) }}" class="btn btn-icon btn-icon rounded-circle btn-success waves-effect waves-float waves-light">
    <i class="fa-regular fa-eye"></i>
</a>
@endif
@else
<button type="button" class="btn btn-icon btn-icon rounded-circle btn-warning waves-effect waves-float waves-light" data-toggle="modal" data-target="#warning">
    <i class="fa-solid fa-triangle-exclamation"></i>
</button>
@endif