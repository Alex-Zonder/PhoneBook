<h1>Регистрация</h1>

<?php
if (count($errors) > 0){
    echo '<hr><b>Ошибки:</b><br>';
    foreach ($errors as $key => $error)
        echo $error . "<br>";
    echo '<hr>';
}
?>

<form method="post">
    <table>
        <tr>
            <td align="right">Логин</td>
            <td><input type="text" name="login" placeholder="Login" value="<?php echo isset($_POST['login']) ? $_POST['login'] : '' ?>"></td>
        </tr>
        <tr>
            <td align="right">Почта</td>
            <td><input type="text" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"></td>
        </tr>
        <tr>
            <td align="right">Пароль</td>
            <td><input type="password" name="password" placeholder="Password"></td>
        </tr>
        <tr>
            <td align="right">Пароль</td>
            <td><input type="password" name="password2" placeholder="Password"></td>
        </tr>
    </table>
    <br><input type="submit" value="Зарегистрироваться">
</form>
