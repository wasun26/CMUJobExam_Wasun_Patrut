<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['login_true'])) {
    header("Location: ./?view=room_list");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    register($conn);
}

function register($conn) {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // password to MD5
    $sql_select = "SELECT email, password FROM user WHERE email='$email'";
    $result = $conn->query($sql_select);
    if ($result->num_rows > 0) {
        echo "<script>
        document.onreadystatechange = function () {
            myModal.show();
          };
    </script>";
    } else {
        $sql = "INSERT INTO user(email, password) VALUES ('$email', '$password')";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['login_true'] = $email;
            $conn->close();
            echo ($_SESSION['login_true']);
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
                <h3>Create new Account</h3><br>
                <h6>Already Registered? Log in <a href="?view=login">here</a></h6>
            </td>
        </tr>
        <tr>
            <td>
                <form action="?view=register" method="POST" class="form-control border-0">
                    <div class="form-group">
                        <label for="exampleInputEmail1">EMAIL</label>
                        <div class="alert alert-danger alert-dismissible visually-hidden">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            <strong>Success!</strong> This alert box could indicate a successful or positive action.
                        </div>
                        <input type="email" class="form-control" id="inputEmail" placeholder="email@email.com" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">PASSWORD</label>
                        <input type="password" class="form-control" id="inputPassword" minlength="6" placeholder="******" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">CONFIRM PASSWORD</label>
                        <input type="password" class="form-control" id="inputConfirmPassword" minlength="6" placeholder="******" name="password" required>
                    </div>
                    <br>
                    <div class="form-group">
                        <input class="form-check-input" type="checkbox" id="check1" name="option1" value="" required>
                        <label class="form-check-label">I AGREE TO THE TERMS SERVICE PRIVACY POLICY</label>
                    </div>
                    <br>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary form-control">Sign up</button>
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
                    Email ซํ้า โปรดเลือก Email อื่น
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

    var password = document.getElementById("inputPassword"),
        confirm_password = document.getElementById("inputConfirmPassword");

    function validatePassword() {
        if (password.value != confirm_password.value) {
            confirm_password.setCustomValidity("Passwords Don't Match");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>