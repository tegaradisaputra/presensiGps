@if($histori->isEmpty())
    <div class="alert alert-warning">
        Tidak ada data presensi untuk bulan dan tahun yang dipilih.
    </div>
@endif
@foreach ($histori as $d)
    <ul class="listview image-listview">
        @foreach ($histori as $d)
            <li>
                <div class="item">
                    @php
                        $path = Storage::url('uploads/absensi/' . $d->photo_in);
                    @endphp
                    <img src="{{ url($path) }}" alt="image" class="image">
                    <div class="in">
                        <div>
                            <b>{{ date('d-m-Y',strtotime($d->attendance_date)) }}</b><br>
                        </div>
                        <span class="badge {{ $d->time_in < '07:00' ? 'bg-success' : 'bg-warning' }}">
                            {{ $d->time_in }}
                        </span>
                        @if($d->time_out)
                            <span class="badge bg-primary">
                                {{ $d->time_out }}
                            </span>
                        @endif

                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@endforeach