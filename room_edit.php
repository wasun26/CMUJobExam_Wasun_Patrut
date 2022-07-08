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
        <a href="?view=logout" class="btn btn-danger">Logout</a>
    </div>
<?php
}

if (isset($_GET['rid'])) {
    $rid = $_GET['rid'];
} else {
    $rid = $_POST['edit_id'];
    $sql = "SELECT * FROM room WHERE id = $rid";
    $result = $conn->query($sql);
    $dbarr = mysqli_fetch_array($result, MYSQLI_BOTH);
}

$sql = "SELECT * FROM room WHERE id = $rid";
$result = $conn->query($sql);
$dbarr = mysqli_fetch_array($result, MYSQLI_BOTH);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    edit_room($conn);
}

function edit_room($conn) {
    $room_name = $_POST['InputRoomName'];
    $number_of_student = $_POST['InputNumberOfStudent'];
    $sql = "UPDATE room SET room_name='$room_name', number_of_student='$number_of_student' WHERE id= $_POST[edit_id]";
    if ($conn->query($sql) === TRUE) {
        $conn->close();
        header("Location: ./?view=room_edit&rid=$_POST[edit_id]");
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
                <form action="?view=room_edit" method="POST" class="form-control border-0">
                    <div class="form-group">
                        <label for="InputRoomName">NAME</label>
                        <input type="text" class="form-control" id="InputRoomName" placeholder="Examination Name" name="InputRoomName" value="<?php echo ($dbarr['room_name']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="InputNumberOfStudent">NUMBER OF STUDENT</label>
                        <input type="number" class="form-control" id="InputNumberOfStudent" placeholder="0" name="InputNumberOfStudent" min="0" max="999" maxlength="3" value="<?php echo ($dbarr['number_of_student']); ?>" required>
                    </div>
                    <div class="form-group">
                        <br>
                        <button type="submit" class="btn btn-primary form-control">Edit</button>
                        <a href="?view=room_del&rid=<?php echo ($rid); ?>" class="btn btn-danger form-control">Delete</a>
                    </div>
                    <input type="hidden" value="<?php echo ($rid); ?>" name="edit_id" id="edit_id">
                </form>
            </td>
        </tr>
    </tbody>
</table>

<script>
    var myModal = new bootstrap.Modal(document.getElementById("myModal"), {});
</script>