<?= $this->include('partials/header') ?>
<body>
    <?= $this->include('partials/navbar') ?>
    <?= $this->include('partials/hero') ?>
    
    <main>
        <?= $this->include('partials/rooms.php')?>
        <?= $this->include('partials/facilities') ?>
        
    </main>

    <?= $this->include('partials/footer') ?>
    <?= $this->include('partials/modals/room_detail') ?>
    <?= $this->include('partials/scripts') ?>
</body>
</html>