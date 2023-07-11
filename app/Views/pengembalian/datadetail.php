<hr style="height:2px;border-width:0;color:white;background-color:white">

<table class="table table-sm table-hover table-bordered" style="width: 100%;" id="datadetail">
    <thead>
        <tr>
            <th>No.</th>
            <th>ID Pakai</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Jenis</th>
            <th>Ketarangan</th>
            <th>Jumlah</th>
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
                <input type="hidden" value="<?= $row['detpgmid'] ?>" id="id">
            </td>
            <td><?= $row['detpgmpmkid']; ?></td>
            <td><?= $row['detpgmbrgkode']; ?></td>
            <td><?= $row['brgnama']; ?></td>
            <td><?= $row['detpgmjenis']; ?></td>
            <td><?= $row['detpgmketerangan']; ?></td>
            <td align="right"><?= number_format($row['detpgmjumlah'], 0, ",", "."); ?></td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $row['detpgmid'] ?>')"><i
                        class="fa fa-trash-alt"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
function hapusItem(detpgmid) {
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
                url: "<?= base_url() ?>/pengembalian/hapusItemDetail",
                data: {
                    detpgmid: detpgmid
                },
                dataType: "json",
                success: function(response) {
                    if (response.sukses) {
                        swal.fire('Berhasil', response.sukses, 'success');
                        tampilDataDetail();
                        kosong();
                    }
                }
            });
        }
    })
}

$('#datadetail tbody').on('click', 'tr', function() {
    let row = $(this).closest('tr');

    let detpgmpmkid = row.find('td:eq(1)').text();
    let pgmbrgkode = row.find('td:eq(2)').text();
    let pgmjenis = row.find('td:eq(4)').text();
    let pgmketerangan = row.find('td:eq(5)').text();
    let id = row.find('td input').val();

    $('#detpgmid').val(id);
    $('#detpgmpmkid').val(detpgmpmkid);
    $('#pgmbrgkode').val(pgmbrgkode);
    $('#pgmjenis').val(pgmjenis);
    $('#pgmketerangan').val(pgmketerangan);

    $('#tombolBatal').fadeIn();
    $('#tombolEditItem').fadeIn();
    $('#pgmbrgkode').prop('readonly', true);
    $('#pgmjenis').prop('disabled', true);
    $('#tombolCari').prop('disabled', true);
    $('#tombolCariBarang').prop('disabled', true);
    $('#tombolSimpanItem').fadeOut();
    ambilDataBarang();
});

$(document).on('click', '#tombolBatal', function(e) {
    e.preventDefault();
    kosong();
    tampilDataDetail();
    $('#tombolBatal').fadeOut();
    $('#tombolEditItem').fadeOut();
    $('#pgmbrgkode').prop('readonly', false);
    $('#tombolCari').prop('disabled', false);
    $('#tombolCariBarang').prop('disabled', false);
    $('#tombolSimpanItem').fadeIn();
});
</script>