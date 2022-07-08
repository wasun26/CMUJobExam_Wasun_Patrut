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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    create_room($conn);
}

function create_room($conn) {
    $roomName = $_POST['InputRoomName'];
    $numberOfStudent = $_POST['InputNumberOfStudent'];
    $sql_select = "SELECT room_name FROM room WHERE room_name='$roomName'";
    $result = $conn->query($sql_select);
    if ($result->num_rows > 0) {
        echo "<script>
        document.onreadystatechange = function () {
            myModal.show();
          };
    </script>";
    } else {
        $sql = "INSERT INTO room(room_name, number_of_student) VALUES ('$roomName', '$numberOfStudent')";
        if ($conn->query($sql) === TRUE) {
            $conn->close();
            header("location: ./?view=room_list");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    $conn->close();
}
?>
<table class="table">
    <tbody>
        <tr align="center">
            <td>
                <h2>Create</h2><br>
                Create new Examination Room
            </td>
        </tr>
        <tr>
            <td>
                <form action="?view=room_create" method="POST" class="form-control border-0">
                    <div class="form-group">
                        <label for="InputRoomName">NAME</label>
                        <input type="text" class="form-control" id="InputRoomName" placeholder="Examination Name" name="InputRoomName" required>
                    </div>
                    <div class="form-group">
                        <label for="InputNumberOfStudent">NUMBER OF STUDENT</label>
                        <input type="number" class="form-control" id="InputNumberOfStudent" placeholder="0" name="InputNumberOfStudent" min="0" max="999" maxlength="3" required>
                    </div>
                    <div class="form-group">
                        <br>
                        <button type="submit" class="btn btn-primary form-control">Create</button>
                    </div>
                </form>
            </td>
        </tr>
    </tbody>
</table>

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ข้อความจากระบบ</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-danger justify-content-center">
                <div class="swal2-icon swal2-error swal2-animate-error-icon" style="display: flex;">
                    <span class="swal2-x-mark">
                        <span class="swal2-x-mark-line-left"></span>
                        <span class="swal2-x-mark-line-right"></span>
                    </span>
                </div>
                <div class="d-flex justify-content-center">
                    ชื่อห้องซํ้า โปรดใช้ชื่ออื่น
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
    var myModal = new bootstrap.Modal(document.getElementById("myModal"), {});
</script>