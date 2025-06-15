<style>
    /* Modal Detail Styling */
    .modal-content {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: none;
        overflow: hidden;
    }

    /* .modal-header {
        background-color: #007bff;
        color: white;
        border-bottom: 2px solid #0056b3;
        padding: 15px 20px;
    } */

    .modal-title {
        font-weight: 600;
        font-size: 1.5rem;
    }

    .modal-body {
        padding: 20px;
        background-color: #f8f9fa;
    }

    .modal-body h4 {
        font-size: 1.8rem;
        color: #19da4c;
        /* Red for SPO level to make it stand out */
        margin-bottom: 20px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        padding-bottom: 10px;
    }

    .modal-body h4::after {
        content: '';
        position: absolute;
        width: 50px;
        height: 3px;
        background-color: #19da4c;
        bottom: 0;
        left: 0;
    }

    .modal-body p {
        font-size: 1rem;
        margin-bottom: 12px;
        color: #333;
        line-height: 1.6;
    }

    .modal-body p strong {
        color: #495057;
        font-weight: 600;
        display: inline-block;
        width: 150px;
        /* Fixed width for labels */
    }

    /* .modal-body p:hover {
        background-color: #e9ecef;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        padding: 15px 20px;
        background-color: #fff;
    }

    .btn-close {
        filter: invert(1);
        opacity: 0.8;
    } */

    .btn-close:hover {
        opacity: 1;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .modal-body p strong {
            width: 100%;
            display: block;
            margin-bottom: 5px;
        }

        .modal-body p {
            font-size: 0.9rem;
        }

        .modal-body h4 {
            font-size: 1.5rem;
        }
    }

    /* Animation for modal opening */
    .modal.fade .modal-dialog {
        transform: scale(0.8);
        transition: transform 0.3s ease-out;
    }

    .modal.show .modal-dialog {
        transform: scale(1);
    }
</style>

<div class="modal-body">
    @php
        $spoLevelMap = [
            'spo_1' => 'SPO 1',
            'spo_2' => 'SPO 2',
            'spo_3' => 'SPO 3',
        ];
        $spoLevel = $spoLevelMap[$spo->level_spo] ?? 'SPO';
    @endphp

    <h4>{{ $spoLevel }}</h4>
    <p><strong>Nomor SPO:</strong> {{ $spo->number_spo }}</p>
    <p><strong>Nama Siswa:</strong> {{ $spo->student->name }}</p>
    <p><strong>Pelanggaran:</strong> {{ $spo->pelanggaran->violation->nama_pelanggaran }}</p>
    <p><strong>Point:</strong> {{ $spo->pelanggaran->points }}</p>
    <p><strong>Wali Kelas:</strong> {{ $spo->waliKelas->name ?? '-' }}</p>
    <p><strong>Waka Siswa:</strong> {{ $spo->wakaSiswa->name ?? '-' }}</p>
    <p><strong>Kepala Sekolah:</strong> {{ $spo->kepalaSekolah->name ?? '-' }}</p>
    <p><strong>Tanggal Dibuat:</strong> {{ $spo->created_at->format('d M Y') }}</p>
</div>
