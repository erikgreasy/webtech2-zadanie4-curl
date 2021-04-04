<?php include 'header.php' ?>

<main>
    <div class="container">
        <h1 class="display-4">Štatistiky</h1>
            <script>
                var lectures = <?= json_encode($lectures) ?>
            </script>
            <canvas id="myChart" width="400" height="400"></canvas>
    </div>
</main>

<?php include 'footer.php' ?>
