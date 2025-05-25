<?= $this->include('partials/header') ?>
<body>
    <?= $this->include('partials/navbar') ?>
    <?= $this->include('partials/hero') ?>
    
    <main>
        <?= $this->include('partials/rooms') ?>
        <?= $this->include('partials/facilities') ?>
        <?= $this->include('partials/testimonials') ?>
    </main>

    <?= $this->include('partials/footer') ?>
    <?= $this->include('partials/modals/room_detail') ?>
    <?= $this->include('partials/scripts') ?>
</body>
</html>