<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembayaran Pajak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .kop-surat {
            width: 100%;
            margin-bottom: 20px;
            /* padding-bottom: 10px; */
            border-collapse: collapse;
        }
        .kop-surat td {
            vertical-align: middle;
            border: none;  /* Pastikan semua sel tanpa border */
        }
        .kop-surat img {
            text-align: right
        }
        .kop-surat .text {
            text-align: center;
        }
        .kop-surat h1, .kop-surat h2 {
            margin: 5px 0;
            font-size: 22px;
        }
        .kop-surat p {
            margin: 5px 0;
            font-size: 14px;
        }
        /* Garis bawah tebal di bawah kop surat */
        .garis-bawah {
            width: 100%;
            border-bottom: 3px solid #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
        th {
            background-color: #f2f2f2;
        }
        h1, h3 {
            text-align: center;
        }
        .footer {
            position: absolute;
            bottom: 30px;
            right: 50px;
            text-align: center;
            width: 250px;
        }
    </style>
</head>
<body>

    <!-- Kop Surat Menggunakan Tabel (Tanpa Garis Tabel) -->
    <table class="kop-surat" style="border: none;"> <!-- border: none untuk tabel -->
        <tr>
            <td style="border: none;">
                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiMJ40EEQsuI0CKJ3jjAmNEqAyZVzkNtpBlaT5ieDjZe4se13LaX4X23PpgKVDCPeGsYLKla-iceNrWQNRxQ7eUq780aBYS3r1zZt_aFnV1a2AewIm9LXS1Qrh1sGrx-rpz3F31Y_TMNqvIVL9wvVDxBdnkUfHW9CfCsO_yf41viNz8dprZKHaQa7DX/s320/GKL26_Banjarbaru%20-%20Koleksilogo.com.jpg" alt="Logo Banjarbaru" width="125px" height="100px">
            </td>
            <td class="text" style="border: none;">
                <h1>PEMERINTAH KOTA BANJARBARU</h1>
                <h1>BADAN PENDAPATAN DAERAH (BAPENDA)</h1>
                <p>Jl. Pangeran Antasari No. 15, Banjarbaru</p>
                <p>Telepon: (0511) 4771234 | Email: bapenda@banjarbaru.go.id</p>
            </td>
        </tr>
    </table>

    <!-- Garis Bawah Tebal -->
    <div class="garis-bawah"></div>

    <h2 style="text-align: center">Laporan Pembayaran Pajak</h2>
    @if($startDate && $endDate)
        <h3>Periode: {{ $startDate }} s/d {{ $endDate }}</h3>
    @endif
    
    <!-- Tabel Laporan -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Plat</th>
                <th>Nama Pemilik</th>
                <th>Jumlah Pembayaran</th>
                <th>Tanggal Pembayaran</th>
                <th>Metode Pembayaran</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            @php($no = 1)
            @foreach ($payments as $row)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $row->plate_number }}</td>
                <td>{{ $row->user_name }}</td>
                <td>Rp {{ number_format($row->payment_amount, 2, ',', '.') }}</td>
                <td>{{ $row->payment_date }}</td>
                <td>{{ ucfirst($row->payment_method) }}</td>
                <td>{{ ucfirst($row->payment_status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer Tanda Tangan -->
    <div class="footer">
        <p>Banjarbaru, {{ date('d-m-Y') }}</p>
        <p>Mengetahui,</p>
        <br><br><br>
        <b>Septia Dewi Santika, SE.</b><br>
        <i>Kepala Bapenda Banjarbaru</i>
    </div>
</body>
</html>