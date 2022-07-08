<!DOCTYPE html>
<style>
    .btn-circle {
        width: 30 px;
        height: 30 px;
        padding: 6 px 0 px;
        border-radius: 15 px;
        text-align: center;
        font-size: 12 px;
        line-height: 1.42857;
    }
</style>
<?php
session_start();
if (!(isset($_SESSION['login_true']))) {
    header("Location: ./?view=login");
    exit;
}

// if isset SESSION login_true, then show logout button left top

if (isset($_SESSION['login_true'])) {
?>
    <div class="col">
        <a href="?view=logout" class="btn btn-danger">Logout</a>
    </div>
<?php
}
?>

<header align="center">
    <h2>Room</h2><br>
    List of examination room
</header>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    $sql = "SELECT * FROM room";
    $result = $conn->query($sql);
    while ($dbarr = mysqli_fetch_array($result, MYSQLI_BOTH)) {
    ?>
        <div class="col text-center">
            <div class="card bg-secondary" style="width: 10rem;">
                <img class="rounded-circle img-fluid mx-auto d-block" src="./img/home.png" alt="Card image">
                <div class="card-body">
                    <a href="?view=room_edit&rid=<?php echo ($dbarr['id']); ?>" class="stretched-link nav-link text-dark">
                        <h4 class=" card-title"><?php echo ($dbarr['room_name']); ?></h4>
                        <h3 class="card-title"><?php echo ($dbarr['number_of_student']); ?></h3>
                    </a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<div class="float-end"><a href="?view=room_create" class="btn-primary btn-circle"><i class="fa-solid fa-circle-plus fa-2xl"></i></a></div><br>