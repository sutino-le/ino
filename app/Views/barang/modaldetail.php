<!-- Modal -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <?= csrf_field(); ?>

            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-sm">
                    <tr>
                        <td>Kode Barang</td>
                        <td>:</td>
                        <td><?= $brgkode ?></td>
                    </tr>
                    <tr>
                        <td>Nama Barang</td>
                        <td>:</td>
                        <td><?= $brgnama ?></td>
                    </tr>
                </table>

                <table class="table-sm">
                    <tr>
                        <td>TTB</td>
                        <td>Pemakaian</td>
                        <td>Pengembalian</td>
                    </tr>
                    <tr valign="top">
                        <td>
                            <table class="table-sm table-bordered">
                                <tr bgcolor="gray">
                                    <td>Tanggal</td>
                                    <td>Qty</td>
                                    <td>User</td>
                                </tr>
                                <?php
                                $totalttb = 0;
                                foreach ($datapenerimaan->getResultArray() as $rowPenerimaan) :
                                ?>
                                <tr>
                                    <td><?= $rowPenerimaan['ttbtanggal'] ?></td>
                                    <td><?= $rowPenerimaan['ttbjml'] ?></td>
                                    <td><?= $rowPenerimaan['ttbpenerima'] ?></td>
                                </tr>
                                <?php
                                    $totalttb += $rowPenerimaan['ttbjml'];
                                endforeach
                                ?>
                                <tr bgcolor="gray">
                                    <td>Total</td>
                                    <td><?= $totalttb ?></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                        <td>
                            <table class="table-sm table-bordered">
                                <tr bgcolor="gray">
                                    <td>Tanggal</td>
                                    <td>Jenis</td>
                                    <td>Qty</td>
                                    <td>Ket</td>
                                    <td>User</td>
                                </tr>
                                <?php
                                $totalPemakaian = 0;
                                foreach ($datapemakaian->getResultArray() as $rowPemakaian) :
                                ?>
                                <tr>
                                    <td><?= $rowPemakaian['pmktanggal'] ?></td>
                                    <td><?= $rowPemakaian['pmkjenis'] ?></td>
                                    <td><?= $rowPemakaian['pmkjumlah'] ?></td>
                                    <td><?= $rowPemakaian['pmkketerangan'] ?></td>
                                    <td><?= $rowPemakaian['ktp_nama'] ?></td>
                                </tr>
                                <?php
                                    $totalPemakaian += $rowPemakaian['pmkjumlah'];
                                endforeach
                                ?>

                                <tr bgcolor="gray">
                                    <td colspan="2">Total</td>
                                    <td><?= $totalPemakaian ?></td>
                                    <td colspan="2"></td>
                                </tr>
                            </table>
                        </td>
                        <td>

                            <table class="table-sm table-bordered">
                                <tr bgcolor="gray">
                                    <td>Tanggal</td>
                                    <td>Qty</td>
                                    <td>Ket</td>
                                    <td>User</td>
                                </tr>
                                <?php
                                $totalPengambalian = 0;
                                foreach ($datapengembalian->getResultArray() as $rowPengembalian) :
                                ?>
                                <tr>
                                    <td><?= $rowPengembalian['pgmtanggal'] ?></td>
                                    <td><?= $rowPengembalian['detpgmjumlah'] ?></td>
                                    <td><?= $rowPengembalian['detpgmketerangan'] ?></td>
                                    <td><?= $rowPengembalian['ktp_nama'] ?></td>
                                </tr>

                                <?php
                                    $totalPengambalian += $rowPengembalian['detpgmjumlah'];
                                endforeach
                                ?>

                                <tr bgcolor="gray">
                                    <td colspan="2">Total</td>
                                    <td><?= $totalPengambalian ?></td>
                                    <td colspan="2"></td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>



                <table class="table table-sm">
                    <tr>
                        <td>Total TTB</td>
                        <td>:</td>
                        <td><?= $totalttb ?></td>
                    </tr>
                    <tr>
                        <td>Total Pemakaian</td>
                        <td>:</td>
                        <td><?= $totalPemakaian ?></td>
                    </tr>
                    <tr>
                        <td>Total Pengembalian</td>
                        <td>:</td>
                        <td><?= $totalPengambalian ?></td>
                    </tr>
                    <tr bgcolor="gray">
                        <td><b>Stock Akhir</b></td>
                        <td><b>:</b></td>
                        <td><b><?= $brgstok ?></b></td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="batal">Close</button>
            </div>



        </div>
    </div>
</div>
<!-- 

<script>
    $(document).ready(function() {


        $('#batal').click(function(e) {
            e.preventDefault();
            window.location.reload();
        });

    });
</script> -->