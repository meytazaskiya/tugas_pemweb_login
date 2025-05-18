<?php
session_start();
include "koneksi/db.php";

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === 'admin' && $pass === '123') {
        $_SESSION['user'] = $user;
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Data Mahasiswa</title>
</head>
<body class="container mt-5">

<?php if (!isset($_SESSION['user'])): ?>
  <h2>Login</h2>
  <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <form method="post">
    <div class="mb-3">
      <label>Username</label>
      <input type="text" name="username" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Password</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button type="submit" name="login" class="btn btn-primary">Login</button>
  </form>

<?php else: ?>
  <h2>Data Mahasiswa</h2>
  <a href="koneksi/add.php" class="btn btn-primary mb-3">+ Tambah Mahasiswa</a>
  <a href="index.php?logout=true" class="btn btn-danger mb-3 float-end">Logout</a>

  <table class="table table-bordered">
    <thead class="table-dark">
      <tr><th>No</th><th>Nama</th><th>NIM</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $result = mysqli_query($conn, "SELECT * FROM mahasiswa");
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>$no</td>
                <td>{$row['nama']}</td>
                <td>{$row['nim']}</td>
                <td>
                  <a href='koneksi/edit.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                  <a href='koneksi/delete.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Hapus data ini?\")'>Hapus</a>
                </td>
              </tr>";
        $no++;
      }
      ?>
    </tbody>
  </table>
<?php endif; ?>

</body>
</html>
