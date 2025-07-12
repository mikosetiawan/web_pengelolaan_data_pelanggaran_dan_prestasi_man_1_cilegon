<x-app-layout title="Academic Ranking Report">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Academic Ranking Report</h4>
                            <p class="card-description">Ranking based on average grades for semesters 1-5</p>

                            <!-- MIPA Ranking Table -->
                            <h5>MIPA Major</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>NIS</th>
                                            <th>Name</th>
                                            <th>Class</th>
                                            <th>Average Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($mipaRankings as $ranking)
                                            <tr>
                                                <td>{{ $ranking['rank'] }}</td>
                                                <td>{{ $ranking['nis'] }}</td>
                                                <td>{{ $ranking['name'] }}</td>
                                                <td>{{ $ranking['class'] }}</td>
                                                <td>{{ $ranking['average_grade'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No data available for MIPA
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- IPS Ranking Table -->
                            <h5 class="mt-5">IPS Major</h5>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>NIS</th>
                                            <th>Name</th>
                                            <th>Class</th>
                                            <th>Average Grade</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ipsRankings as $ranking)
                                            <tr>
                                                <td>{{ $ranking['rank'] }}</td>
                                                <td>{{ $ranking['nis'] }}</td>
                                                <td>{{ $ranking['name'] }}</td>
                                                <td>{{ $ranking['class'] }}</td>
                                                <td>{{ $ranking['average_grade'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No data available for IPS
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
