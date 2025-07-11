@php
    use App\Models\Gudang;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Invoice - Barang Keluar</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ public_path('front/img/CompanyLogo.png') }}" type="image/x-icon" />

    <!-- Invoice styling -->
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;

        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
            width: 300px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
            display: flex;
            justify-content: space-between;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            width: 50px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
            border: 1px solid #ddd;
            text-align: left;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ public_path('front/img/sanitary.png') }}" alt="Company logo"
                                    style="width: 100%; max-width: 300px" />
                            </td>

                            <td>
                                Invoice:
                                <?php echo strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3)) . rand(1000, 9999); ?><br />
                                Created: <?php echo date('F j, Y, g:i a'); ?><br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                PT. Sanitary Supply Indonesia <br />
                                Jl. Beringin Raya No 20.A<br />
                                Tangerang, 15720<br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Kode Barang</td>

                <td>Nama Barang</td>

                <td>Jenis Barang</td>

                <td>Tanggal Masuk</td>

                <td>Jumlah Masuk</td>
            </tr>

            @foreach ($records as $record)
                <tr class="item">
                    <td>{{ Gudang::where('id', $record->id_barang)->value('kode_barang') ?? 'N/A' }}</td>

                    <td>{{ Gudang::where('id', $record->id_barang)->value('nama_barang') ?? 'N/A' }}</td>

                    <td>{{ Gudang::where('id', $record->id_barang)->value('jenis_barang') ?? 'N/A' }}</td>

                    <td>{{ $record->tanggal_keluar ?? 'N/A' }}</td>

                    <td>{{ $record->jumlah_keluar ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>