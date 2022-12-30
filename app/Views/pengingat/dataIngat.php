<hr style="height:2px;border-width:0;color:white;background-color:white">

<table class="table table-sm table-hover table-bordered" style="width: 100%;" id="dataingat">
    <thead>
        <tr>
            <th>No.</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Lokasi</th>
            <th>Tanggal Awal</th>
            <th>Tanggal Akhir</th>
            <th>User</th>
            <th>Ketarangan</th>
            <th>#</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($tampildata->getResultArray() as $row) :
        ?>
        <tr>
            <td>
                <?= $no++; ?>
                <input type="hidden" value="<?= $row['ingatid'] ?>" id="ingatid">
            </td>
            <td><?= $row['ingatkode']; ?></td>
            <td><?= $row['brgnama']; ?></td>
            <td><?= $row['ingatlocation']; ?></td>
            <td><?= $row['ingatawal']; ?></td>
            <td><?= $row['ingatakhir']; ?></td>
            <td><?= $row['ktp_nama']; ?></td>
            <td><?= $row['ingatketerangan']; ?></td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $row['ingatid'] ?>')"><i
                        class="fa fa-trash-alt"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
function hapusItem(ingatid) {
    let ingatnomor = $('#ingatnomor').val();
    Swal.fire({
        title: 'Hapus Item ?',
        text: "Yakin ingin menghapus Item ini !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "post",
                url: "<?= base_url() ?>/pengingat/hapusItemIngat",
                data: {
                    ingatid: ingatid
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        swal.fire('Berhasil', response.sukses, 'success');
                        tampilDataPengingat();
                    }
                }
            });
        }
    })
}



$('#dataingat tbody').on('click', 'tr', function() {
    let row = $(this).closest('tr');

    let ingatid = row.find('td input').val();

    $('#ingatid').val(ingatid);

    $('#tombolBatal').fadeIn();
    $('#tombolEditItem').fadeIn();
    $('#ingatkode').prop('readonly', true);
    $('#tombolCari').prop('disabled', true);
    $('#tombolSimpanItem').fadeOut();
    ambilDataPengingat();
});

$(document).on('click', '#tombolBatal', function(e) {
    e.preventDefault();
    kosong();
    tampilDataPengingat();
    $('#tombolBatal').fadeOut();
    $('#tombolEditItem').fadeOut();
    $('#ingatkode').prop('readonly', false);
    $('#tombolCari').prop('disabled', false);
    $('#tombolSimpanItem').fadeIn();
});
</script>