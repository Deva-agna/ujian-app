<table class="table" id="table_data">
    <thead>
        <tr role="row">
            <th style="width: 1px;">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="check-all">
                    <label class="custom-control-label" for="check-all"></label>
                </div>
            </th>
            <th>nama</th>
            <th>nis</th>
            <th>kelas</th>
            <th>Ruang</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sub_kelas->siswa as $siswa)
        <tr>
            <td>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input check-siswa" type="checkbox" name="siswa[]" value="{{$siswa->slug}}" id="siswa{{$loop->iteration}}">
                    <label class="custom-control-label" for="siswa{{$loop->iteration}}"></label>
                </div>
            </td>
            <td>{{ $siswa->nama }}</td>
            <td>{{ $siswa->nis }}</td>
            <td class="text-uppercase">{{ $sub_kelas->kelas->nama_kelas }}</td>
            <td class="text-uppercase">{{ $sub_kelas->sub_kelas }}</td>
        </tr>
        @endforeach
    </tbody>
</table>