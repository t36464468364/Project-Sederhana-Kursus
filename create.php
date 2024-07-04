<!DOCTYPE html>
<html>
<head>
    <title>Form Penambahan kursus</title>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $judul = input($_POST["judul"]);
            $deskripsi = input($_POST["deskripsi"]);
            $durasi = input($_POST["durasi"]);
            $link = input($_POST["link"]);

            // Melindungi dari SQL Injection dengan mysqli_real_escape_string
            $judul = mysqli_real_escape_string($kon, $judul);
            $deskripsi = mysqli_real_escape_string($kon, $deskripsi);
            $durasi = mysqli_real_escape_string($kon, $durasi);
            $link = mysqli_real_escape_string($kon, $link);

            $sql = "INSERT INTO peserta (judul, deskripsi, durasi, link) VALUES ('$judul', '$deskripsi', '$durasi', '$link')";

            $hasil = mysqli_query($kon, $sql);

            if ($hasil) {
                header("Location: index.php");
                exit; // Pastikan untuk keluar dari skrip setelah melakukan redirect
            } else {
                echo "<div class='alert alert-danger'>Data Gagal disimpan.</div>";
            }
            
        }
        ?>
        <h2>Input Data</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Judul:</label>
                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul" required/>
            </div>
            <div class="form-group">
                <label>Deskripsi:</label>
                <input type="text" name="deskripsi" class="form-control" placeholder="Masukkan deskripsi" required/>
            </div>
            <div class="form-group">
                <label>Durasi:</label>
                <input type="text" name="durasi" class="form-control" placeholder="Masukkan durasi" required/>
            </div>
            <div class="form-group">
                <label>Link Materi:</label>
                <input type="url" name="link" class="form-control" placeholder="Masukkan link materi" required/>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
