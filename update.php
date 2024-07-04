<!DOCTYPE html>
<html>
<head>
    <title>Form Pengupdetan kursus</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php
        include "koneksi.php";

        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Ambil data peserta berdasarkan id_peserta jika ada
        if (isset($_GET['id_peserta'])) {
            $id_peserta = input($_GET["id_peserta"]);

            $sql = "SELECT * FROM peserta WHERE id_peserta = $id_peserta";
            $hasil = mysqli_query($kon, $sql);
            $data = mysqli_fetch_assoc($hasil);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id_peserta = input($_POST["id_peserta"]);
            $judul = input($_POST["judul"]);
            $deskripsi = input($_POST["deskripsi"]);
            $durasi = input($_POST["durasi"]);
            $link = input($_POST["link"]);

            // Validasi URL menggunakan filter_var
            if (!filter_var($link, FILTER_VALIDATE_URL)) {
                echo "<div class='alert alert-danger'>Link Materi tidak valid.</div>";
                exit;
            }

            // Escape data
            $judul = mysqli_real_escape_string($kon, $judul);
            $deskripsi = mysqli_real_escape_string($kon, $deskripsi);
            $durasi = mysqli_real_escape_string($kon, $durasi);
            $link = mysqli_real_escape_string($kon, $link);

            // Query UPDATE
            $sql = "UPDATE peserta SET
                        judul = '$judul',
                        deskripsi = '$deskripsi',
                        durasi = '$durasi',
                        link = '$link'
                    WHERE id_peserta = $id_peserta";

            $hasil = mysqli_query($kon, $sql);

            if ($hasil) {
                header("Location: index.php");
            } else {
                echo "<div class='alert alert-danger'> Data Gagal disimpan.</div>";
            }
        }
        ?>
        <h2>Update Data</h2>

        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <div class="form-group">
                <label>Judul:</label>
                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul" required value="<?php echo isset($data['judul']) ? $data['judul'] : ''; ?>"/>
            </div>
            <div class="form-group">
                <label>Deskripsi:</label>
                <input type="text" name="deskripsi" class="form-control" placeholder="Masukkan deskripsi" required value="<?php echo isset($data['deskripsi']) ? $data['deskripsi'] : ''; ?>"/>
            </div>
            <div class="form-group">
                <label>Durasi:</label>
                <input type="text " name="durasi" class="form-control" placeholder="Masukkan durasi" required value="<?php echo isset($data['durasi']) ? $data['durasi'] : ''; ?>"/>
            </div>
            <div class="form-group">
                <label>Link Materi:</label>
                <input type="url" name="link" class="form-control" placeholder="Masukkan link materi" required value="<?php echo isset($data['link']) ? $data['link'] : ''; ?>"/>
            </div>
            <input type="hidden" name="id_peserta" value="<?php echo isset($data['id_peserta']) ? $data['id_peserta'] : ''; ?>"/>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
