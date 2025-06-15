<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Panggilan - {{ $spo->number_spo . '-' . $spo->student->name . '-' . $spo->student->father_name }}</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12pt;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            width: 21cm;
            height: 29.7cm;
            box-sizing: border-box;
        }

        .container {
            width: 100%;
            max-width: 19cm;
            padding: 0;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
        }

        .header .logo {
            margin-right: 20px;
        }

        .header img {
            width: 100px;
            height: auto;
        }

        .header .text {
            text-align: center;
            max-width: calc(100% - 120px);
        }

        .header h1 {
            margin: 5px 0;
            font-size: 14pt;
            font-weight: bold;
        }

        .header p {
            margin: 2px 0;
            font-size: 10pt;
        }

        .details {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            font-size: 10pt;
        }

        .details-left,
        .details-right {
            text-align: left;
        }

        .content {
            line-height: 1.6;
            font-size: 12pt;
        }

        .content p {
            margin: 10px 0;
            text-indent: 1cm;
            text-align: left;
        }

        .content .no-indent {
            text-indent: 0;
        }

        .content table {
            width: 50%;
            margin: 10px 0;
            border-collapse: collapse;
        }

        .content table,
        .content th,
        .content td {
            border: 1px solid black;
        }

        .content th,
        .content td {
            padding: 5px;
            text-align: left;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            margin: 10px;
            font-size: 10pt;
        }

        .signature {
            text-align: center;
        }

        .signature p {
            margin: 5px 0;
        }

        .signature .title {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: -80px;
            font-size: 12pt;
        }

        .level-spo {
            font-weight: bold;
            color: #d32f2f; /* Red for emphasis */
        }
    </style>
</head>

<body>
    @php
        $spoLevelMap = [
            'spo_1' => 'SPO 1',
            'spo_2' => 'SPO 2',
            'spo_3' => 'SPO 3',
        ];
        $spoLevel = $spoLevelMap[$spo->level_spo] ?? 'SPO';
    @endphp
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="{{ asset('assets/logo-man-1.png') }}" alt="Logo">
            </div>
            <div class="text">
                <h1>PEMERINTAH DAERAH KOTA CILEGON</h1>
                <h1>DINAS PENDIDIKAN KEBUDAYAAN DAN OLAH RAGA</h1>
                <h1>MAN 1 KOTA CILEGON</h1>
                <p>Jl. Ir. Sutami No.133, Lebakdenok, Kec. Citangkil, Kota Cilegon, Banten 42442</p>
                <p>NPSN: 20623253 | No SK: 104/BAN-PDM/SK/2024</p>
                <p>Email: smk1ramanuta@yahoo.com | Website: https://man1kotacilegon.sch.id</p>
            </div>
        </div>
        <div class="details">
            <div class="details-left">
                <p>Nomor: {{ $spo->number_spo }}</p>
                <p>Lampiran: -</p>
                <p>Level: <span class="level-spo">{{ $spoLevel }}</span></p>
            </div>
            <div class="details-right">
                <p>Raman Utara, {{ \Carbon\Carbon::parse($spo->date_spo)->translatedFormat('d F Y') }}</p>
                <p>Kepada Yth.</p>
                <p>Hal: SURAT PANGGILAN ({{ $spoLevel }})</p>
                <p>Bapak/Ibu Wali murid dari {{ $spo->student->name }}</p>
                <p>Kelas: {{ $spo->student->class }}</p>
                <p>Tempat: -</p>
            </div>
        </div>
        <div class="content">
            <p class="no-indent">Dengan hormat,</p>
            <p>Sehubungan dengan adanya permasalahan yang harus diselesaikan bersama, maka dengan ini kami mengundang
                kehadiran Bapak/Ibu Wali murid pada:</p>
            <table>
                <tr>
                    <th>Hari/Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($spo->date_spo)->translatedFormat('l / d F Y') }}</td>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <td>{{ \Carbon\Carbon::parse($spo->time_spo)->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <th>Tempat</th>
                    <td>MAN 1 Kota Cilegon</td>
                </tr>
            </table>
            <p class="no-indent">Adapun permasalahan yang dimaksud adalah pelanggaran berikut (Level: <span
                    class="level-spo">{{ $spoLevel }}</span>):</p>
            <table>
                <tr>
                    <th>Pelanggaran</th>
                    <td>{{ $spo->pelanggaran->violation->nama_pelanggaran }}</td>
                </tr>
                <tr>
                    <th>Skor</th>
                    <td>{{ $spo->pelanggaran->points }}</td>
                </tr>
                <tr>
                    <th>Sanksi</th>
                    <td>{{ $spo->pelanggaran->sanksi }}</td>
                </tr>
            </table>
            <p>Mengingat pentingnya hal tersebut, maka kami mengharapkan Bapak/Ibu untuk datang tepat pada waktu yang
                telah ditentukan. Demikian surat panggilan ini kami sampaikan, atas perhatian Bapak/Ibu kami ucapkan
                terima kasih.</p>
        </div>
        <div class="signatures" style="padding:10px;">
            <div class="signature">
                <p class="title">Wali Kelas</p>
                <img src="{{ Storage::url($spo->waliKelas->sign) }}" style="width:120px;" alt="">
                <p><b><u>{{ $spo->waliKelas->name }}</u></b></p>
                <p>NIP: {{ $spo->waliKelas->nip ?? '-' }}</p>
            </div>
            <div class="signature">
                <p class="title">Waka Kesiswaan</p>
                <img src="{{ Storage::url($spo->wakaSiswa->sign) }}" style="width:120px;" alt="">
                <p><b><u>{{ $spo->wakaSiswa->name }}</u></b></p>
                <p>NIP: {{ $spo->wakaSiswa->nip ?? '-' }}</p>
            </div>
        </div>
        <div class="footer">
            <div class="signature">
                <p class="title">Mengetahui,</p>
                <p class="title">Kepala Sekolah</p>
                <img src="{{ Storage::url($spo->kepalaSekolah->sign) }}" style="width:120px;" alt="">
                <p><b><u>{{ $spo->kepalaSekolah->name }}</u></b></p>
                <p>NIP: {{ $spo->kepalaSekolah->nip ?? '-' }}</p>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('afterprint', function() {
            window.close(); // Tutup tab print
            window.opener.location.href = "{{ route('spo.index') }}"; // Kembali ke /spo di tab utama
        });

        // Jalankan print otomatis
        window.print();
    </script>
</body>

</html>