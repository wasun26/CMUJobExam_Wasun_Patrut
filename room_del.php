<!DOCTYPE html>
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
        <a href="?view=room_list" class="btn btn-primary">Back</a>
        <a href="?view=logout" class="btn btn-danger">Logout</a>
    </div>
<?php
}

if (isset($_GET['rid'])) {
    $rid = $_GET['rid'];
    $sql = "SELECT * FROM room WHERE id = $rid";
    $result = $conn->query($sql);
    $dbarr = mysqli_fetch_array($result, MYSQLI_BOTH);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['del_id'])) {
    del_room($conn, $_POST['del_id']);
}

function del_room($conn, $rid) {
    $sql = "DELETE FROM room WHERE id=$rid";
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header("Location: ./?view=room_list");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<table class="table">
    <tbody>
        <tr align="center">
            <td>
                <h2>Edit</h2><br>
                Edit <?php echo ($dbarr['room_name']); ?>
            </td>
        </tr>
        <tr>
            <td>
                <form action="?view=room_del" method="POST" class="form-control border-0">
                    <div class="form-group">
                        <label for="InputRoomName">NAME</label>
                        <input type="text" class="form-control" id="InputRoomName" placeholder="Examination Name" name="InputRoomName" value="<?php echo ($dbarr['room_name']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <label for="InputNumberOfStudent">NUMBER OF STUDENT</label>
                        <input type="number" class="form-control" id="InputNumberOfStudent" placeholder="0" name="InputNumberOfStudent" min="0" max="999" maxlength="3" value="<?php echo ($dbarr['number_of_student']); ?>" disabled>
                    </div>
                    <div class="form-group">
                        <br>
                        <button type="submit" class="btn btn-danger form-control">Delete Confirm</button>
                    </div>
                    <input type="hidden" value="<?php echo ($rid); ?>" name="del_id" id="del_id">
                </form>
            </td>
        </tr>
    </tbody>
</table>
</div>