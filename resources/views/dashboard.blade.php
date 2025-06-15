<x-app-layout>
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="row report-inner-cards-wrapper">
                                <div class="col-md-4 col-xl report-inner-card">
                                    <div class="inner-card-text">
                                        <span class="report-title">JUMLAH PRESTASI</span>
                                        <h4>{{ $jumlahPrestasi }}</h4>
                                        <span class="report-count">Data</span>
                                    </div>
                                    <div class="inner-card-icon bg-success">
                                        <i class="icon-rocket"></i>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xl report-inner-card">
                                    <div class="inner-card-text">
                                        <span class="report-title">JUMLAH PELANGGARAN</span>
                                        <h4>{{ $jumlahPelanggaran }}</h4>
                                        <span class="report-count">Data</span>
                                    </div>
                                    <div class="inner-card-icon bg-danger">
                                        <i class="icon-briefcase"></i>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xl report-inner-card">
                                    <div class="inner-card-text">
                                        <span class="report-title">JUMLAH SISWA</span>
                                        <h4>{{ $jumlahSiswa }}</h4>
                                        <span class="report-count">Data</span>
                                    </div>
                                    <div class="inner-card-icon bg-warning">
                                        <i class="icon-globe-alt"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-sm-flex align-items-center mb-4">
                                <h4 class="card-title mb-sm-0">Daftar Siswa Scores Point Rewards</h4>
                                {{-- <a href="#" class="text-dark ms-auto mb-3 mb-sm-0">View all siswas</a> --}}
                            </div>
                            <div class="d-flex mb-3">
                                <label for="perPage" class="me-2">Show</label>
                                <select id="perPage" name="per_page" onchange="this.form.submit()" class="form-select w-auto">
                                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <span class="ms-2">entries</span>
                            </div>
                            <div class="table-responsive border rounded p-1">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="font-weight-bold">ID Siswa</th>
                                            <th class="font-weight-bold">Nama Siswa</th>
                                            <th class="font-weight-bold">Kategori</th>
                                            <th class="font-weight-bold">Point</th>
                                            <th class="font-weight-bold">Created</th>
                                            <th class="font-weight-bold">Updated</th>
                                            <th class="font-weight-bold">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)
                                            <tr>
                                                <td>{{ $item->student_id }}</td>
                                                <td>{{ $item->student_name }}</td>
                                                <td>{{ $item->category }}</td>
                                                <td>
                                                    @if ($item->points)
                                                        <img src="{{ asset('assets/images/dashboard/alipay.png') }}"
                                                            alt="alipay" class="gateway-icon me-2"> {{ $item->points }} /Score
                                                    @else
                                                        <img src="{{ asset('assets/images/dashboard/alipay.png') }}"
                                                            alt="alipay" class="gateway-icon me-2"> Beasiswa
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y') }}</td>
                                                <td>
                                                    <div class="badge {{ $item->status == 'Pelanggaran' ? 'badge-danger' : 'badge-success' }} p-2">
                                                        {{ $item->status }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">No data available</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex mt-4 flex-wrap align-items-center">
                                <p class="text-muted mb-sm-0">
                                    Showing {{ $data->firstItem() }} to {{ $data->lastItem() }} of {{ $data->total() }} entries
                                </p>
                                <nav class="ms-auto">
                                    {{ $data->appends(['per_page' => $perPage])->links('pagination::bootstrap-4') }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</x-app-layout>