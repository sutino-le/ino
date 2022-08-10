 <!-- DataTables -->
 <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
 <link rel="stylesheet" href="<?= base_url() ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
 <script src="<?= base_url() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
 <script src="<?= base_url() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
 <script src="<?= base_url() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
 <script src="<?= base_url() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

 <!-- Modal -->
 <div class="modal fade" id="modalcaribarangbeli" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="staticBackdropLabel">Data Cari Barang Pembelian</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">

                 <table style="width: 100%;" id="datapembelian" class="table table-sm table-bordered table-hover dataTable dtr-inline collapsed">
                     <thead>
                         <tr>
                             <th>No</th>
                             <th>Faktur</th>
                             <th>Nama Barang</th>
                             <th>Jumlah</th>
                             <th>Aksi</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $nomor = 1;
                            foreach ($tampilpembelian->getResultArray() as $rowbeli) :
                            ?>
                             <tr>
                                 <td><?= $nomor++ ?></td>
                                 <td><?= $rowbeli['detfaktur'] ?></td>
                                 <td><?= $rowbeli['brgnama'] ?></td>
                                 <td><?= $rowbeli['detjml'] ?></td>
                                 <td><button type="button" class="btn btn-sm btn-info" onclick="pilih('<?= $rowbeli['iddetail'] ?>')" title="Pilih"><i class='fas fa-hand-point-up'></i></button></td>
                             </tr>
                         <?php endforeach ?>
                     </tbody>
                 </table>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>

 <script>
     function pilih(id) {
         $('#kodebeli').val(id);
         $('#modalcaribarangbeli').on('hidden.bs.modal', function(event) {
             ambilDataBarangBeli();
         });

         $('#modalcaribarangbeli').modal('hide');
     }

     $(document).ready(function() {
         listDataBarangBeli();
     });
 </script>