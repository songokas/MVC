<div id="login">
    <?= $error ?>
    <form action="<?=url()?>" method="post">
    <label>Email: <input type="text" size="50" name="email" /></label>
    <label>Password: <input type="password" size="50" name="pass" /></label>
    <input type="submit" value="submit" />
    </form>
</div>