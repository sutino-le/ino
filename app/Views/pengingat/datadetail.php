<hr style="height:2px;border-width:0;color:white;background-color:white">

<table class="table table-sm table-hover table-bordered" style="width: 100%;" id="datadetail">
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
                <input type="hidden" value="<?= $row['pgtid'] ?>" id="pgtid">
            </td>
            <td><?= $row['pgtbrgkode']; ?></td>
            <td><?= $row['brgnama']; ?></td>
            <td><?= $row['pgtlocation']; ?></td>
            <td><?= $row['pgtawal']; ?></td>
            <td><?= $row['pgtakhir']; ?></td>
            <td><?= $row['ktp_nama']; ?></td>
            <td><?= $row['pgtketerangan']; ?></td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="hapusItem('<?= $row['pgtid'] ?>')"><i
                        class="fa fa-trash-alt"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script>
function hapusItem(pgtid) {
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
                url: "<?= base_url() ?>/pengingat/hapusItemIngatDetail",
                data: {
                    pgtid: pgtid
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

$('#datadetail tbody').on('click', 'tr', function() {
    let row = $(this).closest('tr');

    let pgtbrgkode = row.find('td:eq(1)').text();
    let pgtid = row.find('td input').val();
    let pgtlocation = row.find('td:eq(3)').text();
    let pgtawal = row.find('td:eq(4)').text();
    let pgtakhir = row.find('td:eq(5)').text();
    let pgtketerangan = row.find('td:eq(7)').text();

    $('#pgtid').val(pgtid);
    $('#pgtbrgkode').val(pgtbrgkode);
    $('#pgtlocation').val(pgtlocation);
    $('#pgtawal').val(pgtawal);
    $('#pgtakhir').val(pgtakhir);
    $('#pgtketerangan').val(pgtketerangan);

    $('#tombolBatal').fadeIn();
    $('#tombolEditItem').fadeIn();
    $('#pgtbrgkode').prop('readonly', true);
    $('#tombolCari').prop('disabled', true);
    $('#tombolSimpanItem').fadeOut();
    ambilDataBarang();
});

$(document).on('click', '#tombolBatal', function(e) {
    e.preventDefault();
    kosong();
    tampilDataPengingat();
    $('#tombolBatal').fadeOut();
    $('#tombolEditItem').fadeOut();
    $('#pgtbrgkode').prop('readonly', false);
    $('#tombolCari').prop('disabled', false);
    $('#tombolSimpanItem').fadeIn();
});
</script>