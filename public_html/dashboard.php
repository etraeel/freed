<?php
require '../vendor/autoload.php';
date_default_timezone_set('Asia/Tehran');
$servername = "localhost";
$username = "root";
$password = "";
$database = "freeDomain";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    $sql = 'SELECT * FROM `domains` ORDER BY `status` DESC';
    $result = $conn->query($sql);

}


if($_POST && isset($_POST['id'])){
    $sql2 = 'DELETE FROM domains WHERE id=' . (string)$_POST['id'];
    $result2 = mysqli_query($conn, $sql2);
    header("Refresh:0; url=dashboard.php");
}


if($_POST && isset($_POST['new_domain'])){

    $sql3 = 'SELECT * FROM domains WHERE name="'.(string)$_POST['new_domain'].'"';

    $result3 = $conn->query($sql3);
    if ( $result3->num_rows < 1) {
        $sql4 = 'INSERT INTO domains (name,status,date) VALUES ("'.$_POST['new_domain'].'",0,current_timestamp)';
        $result4 = mysqli_query($conn, $sql4);
        header("Refresh:0; url=dashboard.php");
    }

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Free Domains</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="./dist/css/bootstrap-rtl.min.css">
    <!-- template rtl version -->
    <link rel="stylesheet" href="./dist/css/custom-style.css">

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">


    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="./index3.html" class="brand-link">
            <img src="./dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">پنل مدیریت</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <div>
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="./dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">iman seifollahi</a>
                    </div>
                </div>


            </div>
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 mt-4">
                        <h1>لیست دامنه ها</h1>
                    </div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- /.row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DOMAINS</h3>

                                <div class="card-tools">
                                    <div class="input-group input-group-sm" >
                                        <form action="" method="post" class=" float-left d-flex">
                                            <input type="text" name="new_domain" class="form-control float-right" placeholder="ثبت دامنه جدید ">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default"><i class="fa fa-send"></i>
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0 ">
                                <table class="table table-hover">
                                    <tr>
                                        <th>id</th>
                                        <th>نام دامنه</th>
                                        <th>وضعیت</th>
                                        <th>تاریخ آخرین بررسی</th>
                                        <th>عملیات</th>
                                    </tr>
                                    <?php

                                    while ($row = $result->fetch_assoc()) {

                                    ?>
                                    <tr>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo $row['name'] ?></td>
                                        <?php if($row['status'] == 0){ ?>
                                        <td><span class="badge badge-warning">بررسی نشده</span></td>
                                        <?php }if($row['status'] == 1){ ?>
                                        <td><span class="badge badge-danger">گرفته شده</span></td>
                                        <?php }if($row['status'] == 2){ ?>
                                            <td><span class="badge badge-success">آزاد</span></td>
                                        <?php } ?>
                                        <td><?php echo jdate($row['date'])->ago(); ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                                <button type="submit" class="btn btn-block btn-outline-danger" style="max-width: 100px;">حذف</button>
                                            </form>

                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <strong>CopyLeft &copy; 2022 <a href="http://github.com/hesammousavi/">ایمان سیف الهی</a>.</strong>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Slimscroll -->
<script src="./plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="./plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="./dist/js/demo.js"></script>
</body>
</html>
<?php
$conn->close();
?>