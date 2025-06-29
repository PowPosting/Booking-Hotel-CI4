<?= $this->include('partials/header') ?>
<body>
    <?= $this->include('partials/navbar') ?>
    <?= $this->include('partials/hero') ?>
    
    <main>
        <?= $this->include('partials/rooms.php')?>
        <?= $this->include('partials/facilities') ?>
        
    </main>

    <?= $this->include('partials/footer') ?>
    <?= $this->include('partials/modals/room_detail_modal') ?>
    <?= $this->include('partials/modals/choose_room_modal') ?>
    <?= $this->include('partials/modals/checkout') ?>
    <?= $this->include('partials/scripts') ?>
</body>
</html>