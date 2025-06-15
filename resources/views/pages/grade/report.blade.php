<x-app-layout>
    <div class="main-panel">
        <div class="content-wrapper">
            <!-- IPA Section -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-4">Peringkat Siswa Jurusan IPA</h2>
                @if ($ipaStudents->isEmpty())
                    <p class="text-gray-600">Tidak ada data siswa IPA yang tersedia.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Peringkat</th>
                                    <th class="py-3 px-6 text-left">NIS</th>
                                    <th class="py-3 px-6 text-left">Nama</th>
                                    <th class="py-3 px-6 text-left">Kelas</th>
                                    <th class="py-3 px-6 text-left">Nilai Rata-rata</th>
                                    <th class="py-3 px-6 text-left">Semester</th>
                                    <th class="py-3 px-6 text-left">Tahun Ajaran</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($ipaStudents as $student)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left">{{ $student->rank }}</td>
                                        <td class="py-3 px-6 text-left">{{ $student->nis }}</td>
                                        <td class="py-3 px-6 text-left">{{ $student->name }}</td>
                                        <td class="py-3 px-6 text-left">{{ $student->class }}</td>
                                        <td class="py-3 px-6 text-left">{{ number_format($student->average_grade, 2) }}
                                        </td>
                                        <td class="py-3 px-6 text-left">{{ $student->semester }}</td>
                                        <td class="py-3 px-6 text-left">{{ $student->academic_year }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- IPS Section -->
            <div>
                <h2 class="text-xl font-semibold mb-4">Peringkat Siswa Jurusan IPS</h2>
                @if ($ipsStudents->isEmpty())
                    <p class="text-gray-600">Tidak ada data siswa IPS yang tersedia.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg">
                            <thead>
                                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Peringkat</th>
                                    <th class="py-3 px-6 text-left">NIS</th>
                                    <th class="py-3 px-6 text-left">Nama</th>
                                    <th class="py-3 px-6 text-left">Kelas</th>
                                    <th class="py-3 px-6 text-left">Nilai Rata-rata</th>
                                    <th class="py-3 px-6 text-left">Semester</th>
                                    <th class="py-3 px-6 text-left">Tahun Ajaran</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                                @foreach ($ipsStudents as $student)
                                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                                        <td class="py-3 px-6 text-left">{{ $student->rank }}</td>
                                        <td class="py-3 px-6 text-left">{{ $student->nis }}</td>
                                        <td class="py-3 px-6 text-left">{{ $student->name }}</td>
                                        <td class="py-3 px-6 text-left">{{ $student->class }}</td>
                                        <td class="py-3 px-6 text-left">{{ number_format($student->average_grade, 2) }}
                                        </td>
                                        <td class="py-3 px-6 text-left">{{ $student->semester }}</td>
                                        <td class="py-3 px-6 text-left">{{ $student->academic_year }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-app-layout>
