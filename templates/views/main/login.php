<h1>Авторизация</h1>

<form method="post">
    <table>
        <tr>
            <td align="right">Логин</td>
            <td><input type="text" name="login" placeholder="Login or email" value="<?php echo isset($_POST['login']) ? $_POST['login'] : '' ?>"></td>
        </tr>
        <tr>
            <td align="right">Пароль</td>
            <td><input type="password" name="password" placeholder="Password"></td>
        </tr>
    </table>
    <br><input type="submit" value="Войти">
    <hr>
    <a href="/register">Зарегистрироваться</a>
</form>
