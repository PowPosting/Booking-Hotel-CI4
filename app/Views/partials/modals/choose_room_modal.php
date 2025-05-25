<?php
?>
<div class="modal fade" id="chooseRoomModal" tabindex="-1" aria-labelledby="chooseRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="chooseRoomModalLabel">Pilih Nomor Kamar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <form id="formPilihKamar" action="<?= base_url('booking/pesan') ?>" method="post">
          <div id="listNomorKamar" class="row g-3">
            <!-- Daftar kamar akan diisi oleh JavaScript -->
          </div>
          <div class="mt-4 text-center">
            <button type="submit" class="btn btn-primary px-4" id="btnPilihKamar" disabled>Pilih Kamar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
.room-box {
    border: 2px solid #e0e7ef;
    border-radius: 12px;
    padding: 20px 15px;
    text-align: center;
    cursor: pointer;
    background: #ffffff;
    transition: all 0.3s ease;
    position: relative;
    user-select: none;
    display: block;
    height: 100%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}
.room-box.available:hover, .room-box.available.selected {
    border-color: #2563eb;
    background: #f0f7ff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(37,99,235,0.15);
}
.room-box.unavailable {
    background: #f1f5f9;
    color: #94a3b8;
    cursor: not-allowed;
    border: 2px dashed #cbd5e1;
}
.room-number {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 5px;
    color: #1e293b;
}
.room-box.unavailable .room-number {
    color: #94a3b8;
}
.room-status {
    font-size: 0.875rem;
    color: #64748b;
}
.room-box.available .room-status {
    color: #16a34a;
}
.room-box.unavailable .room-status {
    color: #dc2626;
}
.room-box input[type="radio"] {
    display: none;
}
.room-box.selected::after {
    content: "✓";
    position: absolute;
    top: 10px;
    right: 10px;
    background: #2563eb;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}
</style>

<script>
    // Data kamar dari PHP (ambil dari database)
    const kamarTersedia = <?= isset($rooms) ? json_encode($rooms) : '[]' ?>;

    function showChooseRoomModal(roomType) {
        // Filter kamar sesuai tipe
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

    // Handle submit pilih kamar
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('formPilihKamar');
        if(form){
            form.onsubmit = function(e){
                const nomor = form.room_number.value;
                alert('Anda memilih kamar nomor: ' + nomor);
                bootstrap.Modal.getInstance(document.getElementById('chooseRoomModal')).hide();
                // Lanjutkan ke proses booking...
            }
        }
    });
</script>