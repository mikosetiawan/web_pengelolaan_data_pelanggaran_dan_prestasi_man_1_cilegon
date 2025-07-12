<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SPO Siswa Details</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>

</head>

<body>

    <div class="main-panel">
        <div class="content-wrapper">
            <h3>Daftar Keluaran Surat SPO Siswa Tahun {{ date('Y') }}</h3>
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
                                            'spo_3' => 'SPO 3',
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
                                            <td>{{ \Illuminate\Support\Str::words($item->pelanggaran->violation->nama_pelanggaran, 2, '...') }}
                                            </td>
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

    @include('sweetalert::alert')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.btn-view-spo', function() {
            var spoId = $(this).data('id');

            $.ajax({
                url: '/spo/' + spoId + '/view-detail-public',
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

</body>

</html>
