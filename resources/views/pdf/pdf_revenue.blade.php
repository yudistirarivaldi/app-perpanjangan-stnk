<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan Pajak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }
        .kop-surat {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .kop-surat td {
            vertical-align: middle;
            border: none;
        }
        .kop-surat img {
            width: 125px;
            height: 100px;
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
        .garis-bawah {
            width: 100%;
            border-bottom: 3px solid #000;
            margin-bottom: 20px;
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

    <!-- Kop Surat -->
    <table class="kop-surat">
        <tr>
            <td>
                <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiMJ40EEQsuI0CKJ3jjAmNEqAyZVzkNtpBlaT5ieDjZe4se13LaX4X23PpgKVDCPeGsYLKla-iceNrWQNRxQ7eUq780aBYS3r1zZt_aFnV1a2AewIm9LXS1Qrh1sGrx-rpz3F31Y_TMNqvIVL9wvVDxBdnkUfHW9CfCsO_yf41viNz8dprZKHaQa7DX/s320/GKL26_Banjarbaru%20-%20Koleksilogo.com.jpg" alt="Logo Banjarbaru">
            </td>
            <td class="text">
                <h1>PEMERINTAH KOTA BANJARBARU</h1>
                <h1>BADAN PENDAPATAN DAERAH (BAPENDA)</h1>
                <p>Jl. Pangeran Antasari No. 15, Banjarbaru</p>
                <p>Telepon: (0511) 4771234 | Email: bapenda@banjarbaru.go.id</p>
            </td>
        </tr>
    </table>

    <!-- Garis Bawah Tebal -->
    <div class="garis-bawah"></div>

    <h2 style="text-align: center">Laporan Pendapatan Pajak Kendaraan</h2>
    @if($startDate && $endDate)
        <h3>Periode: {{ $startDate }} s/d {{ $endDate }}</h3>
    @endif
    
    <!-- Tabel Laporan -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Plat</th>
                <th>Pemilik</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Kategori</th>
                <th>Pendapatan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php($no = 1)
            @foreach($revenues as $revenue)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $revenue->plate_number }}</td>
                <td>{{ $revenue->pemilik }}</td>
                <td>{{ $revenue->merk }}</td>
                <td>{{ $revenue->model }}</td>
                <td>{{ $revenue->kategori }}</td>
                <td>Rp {{ number_format($revenue->payment_amount, 2, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: right; font-weight: bold;">Total Kendaraan</td>
                <td style="font-weight: bold;">{{ $totalKendaraan }}</td>
            </tr>
            <tr>
                <td colspan="6" style="text-align: right; font-weight: bold;">Grand Total Pendapatan</td>
                <td style="font-weight: bold;">Rp {{ number_format($grandTotal, 2, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Page Break Before Footer -->
    <div class="page-break"></div>

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