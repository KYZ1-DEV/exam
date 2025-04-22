<?php 
require_once 'koneksi.php';

"PHP TAG": {
	"prefix": "php",
	"body": [
		"<?php $1",
		"$0",
		"?>"
	]
	},

	
	"inline echo": {
	"prefix": "phpp",
	"body": "<?= $$1; ?>"
	},

	"php-n": {
	"prefix": "ph",
	"body": "<?php "
	},
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Aplikasi Toko Bunga</title>
    
</head>
<body>

</body>
</html>






	<!-- DOMPdf -->

<?php
require '../../koneksi.php';
require '../../libraries/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$peminjaman = "SELECT t.id_transaksi,a.nisnip, a.nama, b.judul, t.tanggal_pinjam, t.tanggal_kembali, t.denda
                FROM transaksi t
                JOIN anggota a ON t.id_anggota = a.id_anggota
                JOIN buku b ON t.id_buku = b.id_buku
                WHERE t.denda = 0.00
                ORDER BY t.id_transaksi DESC";
$stmtPeminjaman = $pdo->query($peminjaman);

ob_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Transaksi Peminjaman</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }
        table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }
        th, td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }
        th {
            background-color: cadetblue;
            color: #fff;
        }
        .container {
            max-width: 960px;
            margin: auto;
            padding: 20px;
        }
        h2 {
            margin-top: 40px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Laporan Data Transaksi Peminjaman</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Peminjaman</th>
                    <th>NIS/NIP</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Batas Pengembalian</th>
                    
                </tr>
            </thead>
            <tbody>
                    
                <?php while ($transaksi = $stmtPeminjaman->fetch(PDO::FETCH_ASSOC)): ?>
                    
                    <tr>
                        <td><?= $transaksi['id_transaksi'] ?></td>
                        <td><?= $transaksi['nisnip'] ?></td>
                        <td><?= $transaksi['nama'] ?></td>
                        <td><?= $transaksi['judul'] ?></td>
                        <td><?= $transaksi['tanggal_pinjam'] ?></td>
                        <td><?= $transaksi['tanggal_kembali'] ?></td>

                    </tr>

                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$html = ob_get_clean();

// Generate PDF with Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("laporan_transaksi.pdf", ["Attachment" => 0]);
?>

