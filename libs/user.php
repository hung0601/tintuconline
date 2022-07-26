<?php

function db_user_validate($data)
{
    $dt=new database();
    // Biến chứa lỗi
    $error = array();

    /* VALIDATE CĂN BẢN */
    // Username
    if (isset($data['name_user']) && $data['name_user'] == '') {
        $error['username'] = 'Bạn chưa nhập tên đăng nhập';
    }

    // Email
    if (isset($data['email_user']) && $data['email_user'] == '') {
        $error['email'] = 'Bạn chưa nhập email';
    }
    if (isset($data['email_user']) && filter_var($data['email_user'], FILTER_VALIDATE_EMAIL) === false) {
        $error['email'] = 'Email không hợp lệ';
    }

    // Password
    if (isset($data['password_user']) && $data['password_user'] == '') {
        $error['password'] = 'Bạn chưa nhập mật khẩu';
    }

    // Re-password
    if (isset($data['password_user']) && isset($data['re-password']) && $data['password_user'] != $data['re-password']) {
        $error['re-password'] = 'Mật khẩu nhập lại không đúng';
    }

    // Level

    /* VALIDATE LIÊN QUAN CSDL */
    // Chúng ta nên kiểm tra các thao tác trước có bị lỗi không, nếu không bị lỗi thì mới
    // tiếp tục kiểm tra bằng truy vấn CSDL
    // Username
    if (!($error) && isset($data['name_user']) && $data['name_user']) {
        $sql = "SELECT count(id_user) as counter FROM user WHERE name_user='" . addslashes($data['name_user']) . "'";
        $row = $dt->db_get_row($sql);
        if ($row['counter'] > 0) {
            $error['username'] = 'Tên đăng nhập này đã tồn tại';
        }
    }

    // Email
    if (!($error) && isset($data['email_user']) && $data['email_user']) {
        $sql = "SELECT count(id_user) as counter FROM user WHERE email_user='" . addslashes($data['email_user']) . "'";
        $row = $dt->db_get_row($sql);
        if ($row['counter'] > 0) {
            $error['email'] = 'Email này đã tồn tại';
        }
    }

    return $error;
}
