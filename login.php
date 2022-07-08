<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['login_true'])) {
    header("Location: ./?view=room_list");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    login($conn);
}

function login($conn) {
    $email = $_POST['email'];
    $sql = "SELECT email, password FROM user WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $dbarr = $result->fetch_assoc();
        if ($dbarr['email'] == $email && $dbarr['password'] == md5($_POST['password'])) {
            $_SESSION['login_true'] = $email;
            $conn->close();
            echo ($_SESSION['login_true']);
            header("location: ./?");
        }
    }
    $conn->close();
    echo ("<script>document.onreadystatechange = function () {
        myModal.show();
      };</script>");
}
?>
<table class="table">
    <tbody>
        <tr align="center">
            <td>
                <h3>Login</h3><br>
                <h6>Sign in to continue</h6>
            </td>
        </tr>
        <tr>
            <td>
                <form action="?view=login" method="POST" class="form-control border-0">
                    <div class="form-group">
                        <label for="exampleInputEmail1">EMAIl</label>
                        <input type="email" class="form-control" id="inputEmail" placeholder="email@email.com" name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">PASSWORD</label>
                        <input type="password" class="form-control" id="inputPassword" placeholder="******" name="password">
                    </div>
                    <div class="form-group">
                        <br>
                        <button type="submit" class="btn btn-primary form-control">Login</button>
                    </div>
                </form>
                No account? Sign up <a href="?view=register">here</a>
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
                    Email หรือ รหัสผ่าน ไม่ถูกต้อง กรุณาลองอีกครั้ง
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