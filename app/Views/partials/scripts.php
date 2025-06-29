<?php
?>
<!-- Common JavaScript -->
<script src="<?= base_url('assets/js/common.js') ?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Login button click handler - only if element exists
    const loginButton = document.getElementById('loginButton');
    if (loginButton) {
        loginButton.addEventListener('click', function() {
            window.location.href = '<?= site_url('login') ?>';
        });
    }

    function showRoomDetail(title, img1, img2, img3, desc, price) {
        document.getElementById('modalRoomTitle').textContent = title;
        document.getElementById('modalRoomImg1').src = img1;
        document.getElementById('modalRoomImg2').src = img2;
        document.getElementById('modalRoomImg3').src = img3;
        document.getElementById('modalRoomDesc').textContent = desc;
        document.getElementById('modalRoomPrice').textContent = price;
        var myModal = new bootstrap.Modal(document.getElementById('roomDetailModal'));
        myModal.show();
    }

    function showChooseRoomModal(roomType) {
        // Ambil data kamar dari PHP yang sudah di-encode ke JS
        let kamarTipeIni = kamarTersedia.filter(r => r.room_type === roomType);
        let html = '';
        kamarTipeIni.forEach(room => {
            let isAvailable = room.status === 'available';
            html += `
            <div class="col-6 col-md-3 mb-3">
                <label class="room-box ${isAvailable ? 'available' : 'unavailable'}">
                    <input type="radio" name="room_number" value="${room.room_number}" ${isAvailable ? '' : 'disabled'}>
                    <div class="room-number">${room.room_number}</div>
                    <div class="room-status">
                        ${isAvailable ? 'Tersedia' : 'Tidak Tersedia'}
                    </div>
                </label>
            </div>
            `;
        });
        document.getElementById('listNomorKamar').innerHTML = html;
        document.getElementById('btnPilihKamar').disabled = true;

        // Pilih kotak kamar
        document.querySelectorAll('.room-box.available').forEach(function(el) {
            el.onclick = function() {
                document.querySelectorAll('.room-box.available').forEach(box => box.classList.remove('selected'));
                el.classList.add('selected');
                el.querySelector('input').checked = true;
                document.getElementById('btnPilihKamar').disabled = false;
            }
        });

        var modal = new bootstrap.Modal(document.getElementById('chooseRoomModal'));
        modal.show();
    }
    
    // Make functions global so they can be called from HTML
    window.showRoomDetail = showRoomDetail;
    window.showChooseRoomModal = showChooseRoomModal;
});
</script>