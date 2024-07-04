<!DOCTYPE html>
<html>
<head>
    <title>Daftar Kursus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">Ahmada</span>
    </nav>

    <div class="container my-3">
        <h4 class="text-center">DAFTAR KURSUS</h4>

        <?php
        include "koneksi.php";

        // Hapus peserta jika ada parameter id_peserta yang diterima dari URL
        if(isset($_GET['id_peserta'])) {
            $id_peserta = htmlspecialchars($_GET["id_peserta"]);
            $sql = "DELETE FROM peserta WHERE id_peserta='$id_peserta'";
            $hasil = mysqli_query($kon, $sql);

            if($hasil) {
                header("location:index.php");
                exit; // pastikan untuk keluar setelah melakukan redirect
            } else {
                echo "<div class='alert alert-danger'> Data Gagal Dihapus.</div>";
            }
        }
        ?>

        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Durasi</th>
                    <th>Link Materi</th>
                    <th colspan='2'>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM peserta ORDER BY id_peserta DESC";
                $hasil = mysqli_query($kon, $sql);
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                    $no++;
                ?>
                    <tr>
                        <td><?php echo $no; ?></td>
                        <td><?php echo htmlspecialchars($data["judul"]); ?></td>
                        <td><?php echo htmlspecialchars($data["deskripsi"]); ?></td>
                        <td><?php echo htmlspecialchars($data["durasi"]); ?></td>
                        <td><a href="<?php echo htmlspecialchars($data["link"]); ?>" target="_blank"><?php echo htmlspecialchars($data["link"]); ?></a></td>
                        <td>
                            <a href="update.php?id_peserta=<?php echo htmlspecialchars($data['id_peserta']); ?>" class="btn btn-warning btn-sm">Update</a>
                            <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_peserta=<?php echo htmlspecialchars($data['id_peserta']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <a href="create.php" class="btn btn-primary">Tambah Data</a>
    </div>
</body>
</html>
