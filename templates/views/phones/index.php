<center>
    <h3>Телефонная книга <?php echo $this->user['login']; ?></h3><hr>
</center>

<?php
foreach ($phones as $key => $phone) {
    dd($phone);
}
?>
