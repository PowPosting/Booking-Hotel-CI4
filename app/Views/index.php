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
    <?= $this->include('partials/scripts') ?>
    <script src="<?= base_url('js/notifications.js') ?>"></script>
</body>
</html>