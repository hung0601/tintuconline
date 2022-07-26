<?php
include 'top.php';
include 'right.php'

?>

<?php
// Biến chứa lỗi
$error = array();

// VI TRI 1: CODE SUBMIT FORM
// Nếu người dùng submit form
if (is_submit('add_user')) {
    // Lấy danh sách dữ liệu từ form
    $data = array(
        'anh_user' => "",
        'name_user'  => input_post('username'),
        'password_user'  => input_post('password'),
        're-password'  => input_post('re-password'),
        'email_user'     => input_post('email'),
        'fullname_user'  => input_post('fullname'),
        'ngaysinh_user' => input_post('birthday'),
        'phanquyen_user'     => 0,
    );

    // require file xử lý database cho user

    // Thực hiện validate

    $error = db_user_validate($data);
    if (!$error) {
        if (isset($_FILES['image']) && isset($file_tmp)) {
            $a = array();
            $a = explode('.', $_FILES['image']['name']);
            $file_ext = end($a);
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = $data['name_user'] . "." . $file_ext;
            $data['anh_user'] = "avatar/" . $file_name;
            move_uploaded_file($file_tmp, "avatar/" . $file_name);
        } else  $data['anh_user'] = "./avatar/default.png";
        // Xóa key re-password ra khoi $data
        unset($data['re-password']);
        // Nếu insert thành công thì thông báo
        // và chuyển hướng về trang danh sách user
        if ($dt->db_insert('user', $data)) {
?>
            <script language="javascript">
                alert('Đăng kí thành công!');
                window.location = './login.php';
            </script>
<?php
            die();
        }
    }
}
?>


<div id="content1" class="content">
    <h1>Đăng kí tài khoản</h1>
    <div id="ndcontent1" class="ndcontent">
        <form method="post" action="" enctype="multipart/form-data">
            <table cellspacing="0" cellpadding="0" class="form">
                <tr>
                    <td width="200px">Ảnh đại diện</td>
                    <td>

                        <div class="container">
                            <input type="file" id="image_input" name="image" accept="image/*">
                            <div id="display_image">
                                <i class="fas fa-arrow-up upload"></i>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td width="200px">Tên đăng nhập</td>
                    <td>
                        <input type="text" name="username" value="<?php echo input_post('username'); ?>" />
                        <?php show_error($error, 'username'); ?>
                    </td>
                </tr>
                <tr>
                    <td>Fullname</td>
                    <td>
                        <input type="text" name="fullname" value="<?php echo input_post('fullname'); ?>" class="long" />
                        <?php show_error($error, 'fullname'); ?>
                    </td>
                </tr>
                <tr>
                    <td>Mật khẩu</td>
                    <td>
                        <input type="password" name="password" value="<?php echo input_post('password'); ?>" />
                        <?php show_error($error, 'password'); ?>
                    </td>
                </tr>
                <tr>
                    <td>Nhập lại mật khẩu</td>
                    <td>
                        <input type="password" name="re-password" value="<?php echo input_post('re-password'); ?>" />
                        <?php show_error($error, 're-password'); ?>
                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>
                        <input type="text" name="email" value="<?php echo input_post('email'); ?>" class="long" />
                        <?php show_error($error, 'email'); ?>
                    </td>
                </tr>
                <tr>
                    <td>Ngày Sinh</td>
                    <td>
                        <input type="date" name="birthday">
                    </td>
                </tr>

            </table>
            <input type="hidden" name="request_name" value="add_user" />
            <input type="submit" name="signin-confirm" value="Đăng kí" />
        </form>
    </div>

</div>
<script src="js/main.js"></script>

</div><!-- nội dung -->


<?php
include 'bottom.php';

?>