<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title><?php echo $title; ?></title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <!-- VUE development version, includes helpful console warnings -->
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <!-- VUE production version, optimized for size and speed
        <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
    </head>



    <body>
        <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
            <a class="navbar-brand" href="/">Phone Book</a>
            <?php
            if (isset($this) && isset($this->user)) {
                echo "<a href='logout'>Выход</a>";
            }
            ?>
        </nav>

        <div class="container">
            <?php echo $content; ?>
        </div>
    </body>



</html>
