<?php
$conn = mysqli_connect("localhost", "root", "", "sql");

function query($query)
{
    global $conn;
    $data = mysqli_query($conn, $query);
    $karyawan = [];
    while ($karyawan = mysqli_fetch_assoc($data)) {
        $data_karyawan[] = $karyawan;
    }
    return $data_karyawan;
}


function tambah($data)
{
    global $conn;

    $name = $data["name"];
    $email = $data["email"];
    $address = $data["address"];
    $gender = $data["gender"];
    $position = $data["position"];
    $status = $data["status"];

    $query = "INSERT INTO karyawan
                    VALUES
                    ('', '$name', '$email', '$address', '$gender','$position','$status')
                ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}


function hapus($id)
{
    global $conn;
    mysqli_query($conn, "DELETE FROM karyawan WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function status_upload()
{
    if (isset($_POST["submit"])) {
        if (tambah($_POST) > 0) {
            echo "
           <script>
           alert('DATA BERHASIL DIMASUKKAN!');
           document.location.href = 'index.php';
       </script>
            ";
        } else {
            echo "
           <script>
           alert('DATA TIDAK BOLEH KOSONG (NULL)');
           document.location.href = 'index.php';
       </script>
            ";
        }
    }
}

$karyawan = query("SELECT * FROM karyawan");

?>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Praktikum 9</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Tambah karyawan</h1>
        <form action="" method="POST" style="max-width: 500px;  margin-right: auto;
    margin-left: auto;">
            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" name="address">
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select name="gender" class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <select name="position" class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="Boss">Boss</option>
                    <option value="Manager">Manager</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="Parttime">Parttime</option>
                    <option value="Fulltime">Fulltime</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-dark">Submit</button>
        </form>
    </div>
    <?= status_upload(); ?>

    <div class="container">
        <h1>Daftar Karyawan</h1>


        <br>
        <table border="1" class="table table-dark table-striped" cellpadding="10" cellspacing="0">
            <tr>
                <th>
                    No.
                </th>
                <th>Nama</th>
                <th>Email</th>
                <th>Address</th>
                <th>Gender</th>
                <th>Position</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

            <?php
            $count = 1;
            global $count;
            foreach ($karyawan as $item) : ?>
                <tr>
                    <td><?= $count++; ?></td>
                    <td><?= $item["name"] ?></td>
                    <td><?= $item["email"] ?></td>
                    <td><?= $item["address"] ?></td>
                    <td><?= $item["gender"] ?></td>
                    <td><?= $item["position"] ?></td>
                    <td><?= $item["status"] ?></td>
                    <td><a href="hapus.php? id=<?= $item["id"]; ?>" class="btn btn-light" onclick="return confirm('Ingin menghapus data ?')"> Hapus</a></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>