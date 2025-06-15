<x-app-layout title="SPO List siswa">
    <div class="main-panel">
        <div class="content-wrapper">
            <h3>Daftar Keluaran Surat SPO Siswa Tahun {{ date('Y') }}</h3>
            <br>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-12">
                            <p><b>Filter Date</b></p>
                            <form action="{{ route('spo.index') }}" method="GET" class="input-group mb-3">
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </form>
                        </div>
                        <div class="col-lg-6 col-12">
                            <p><b>Filter Siswa</b></p>
                            <form action="{{ route('spo.index') }}" method="GET" class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search Siswa..."
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-secondary bi bi-search"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row table-responsive">
                @foreach ($spo as $item)
                    <div class="col-lg-4 col-6 my-1">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h1>
                                    @php
                                        $spoLevelMap = [
                                            'spo_1' => 'SPO 1',
                                            'spo_2' => 'SPO 2',
                                            'spo_3' => 'SPO 3'
                                        ];
                                        $spoLevel = $spoLevelMap[$item->level_spo] ?? 'SPO';
                                    @endphp
                                    {{ $spoLevel }}
                                </h1>
                                <h5>Nomor : {{ $item->number_spo }}</h5>
                                <hr>
                                <h3 style="font-weight: 800;">{{ $item->student->name }}</h3>
                                <br>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Pelanggaran</th>
                                            <th>Point</th>
                                        </tr>
                                        <tr>
                                            <td>{{ \Illuminate\Support\Str::words($item->pelanggaran->violation->nama_pelanggaran, 2, '...') }}</td>
                                            <td>{{ $item->pelanggaran->points }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="row">
                                    <div class="col-lg-6 col-6">
                                        <button class="btn btn-success bi bi-eye-fill btn-view-spo"
                                            data-id="{{ $item->id }}"> View</button>
                                    </div>
                                    <div class="col-lg-6 col-6">
                                        <a href="{{ route('spo.report', $item->id) }}" target="_blank"
                                            class="btn btn-warning bi bi-printer"> Print</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal for View Detail -->
    <div class="modal fade" id="spoDetailModal" tabindex="-1" aria-labelledby="spoDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="spoDetailModalLabel">Detail SPO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="spoDetailContent">
                    <!-- Data will be loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.btn-view-spo', function() {
            var spoId = $(this).data('id');

            $.ajax({
                url: '/spo/' + spoId + '/view-detail',
                type: 'GET',
                success: function(response) {
                    $('#spoDetailContent').html(response);
                    $('#spoDetailModal').modal('show');
                },
                error: function() {
                    alert('Gagal memuat detail SPO.');
                }
            });
        });
    </script>
</x-app-layout>