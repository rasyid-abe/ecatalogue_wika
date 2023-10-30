<?php
header("Content-Type: text/csv");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 2010 05:00:00 GMT");
header("content-disposition: attachment;filename=data_lelang_".time().".xls");
 ?>
 <table border="1" style="border-collapse : collapse">
     <thead>
         <tr>
             <td colspan = "15" align ="center"><h2>Data Lelang </h2></td>
         </tr>
         <tr>
             <th>No</th>
             <th>Departemen</th>
             <th>Kategori</th>
             <th>Nama</th>
             <th>Spesifikasi</th>
             <th>Mata Uang</th>
             <th>Harga</th>
             <th>Vendor</th>
             <th>Tanggal Kontrak</th>
             <th>Tanggal Akhir Kontrak</th>
             <th>Volume</th>
             <th>Satuan</th>
             <th>Proyek Pengguna</th>
             <th>Lokasi</th>
             <th>Keterangan</th>
         </tr>
     </thead>
     <?php
     if ($data !== NULL)
     {
         $no = 1;
         foreach ($data as $key => $value)
         {
             ?>
             <tr>
                 <td><?php echo $no++ ?></td>
                 <td><?php echo $value->departemen ?></td>
                 <td><?php echo $value->kategori ?></td>
                 <td><?php echo $value->nama ?></td>
                 <td><?php echo $value->spesifikasi ?></td>
                 <td><?php echo $value->currency ?></td>
                 <td><?php echo $value->harga ?></td>
                 <td><?php echo $value->vendor ?></td>
                 <td><?php echo $value->tgl_terkontrak ?></td>
                 <td><?php echo $value->tgl_akhir_kontrak ?></td>
                 <td><?php echo $value->volume ?></td>
                 <td><?php echo $value->satuan ?></td>
                 <td><?php echo $value->proyek_pengguna ?></td>
                 <td><?php echo $value->lokasi ?></td>
                 <td><?php echo $value->keterangan ?></td>
             </tr>
             <?php
         }
     }
     else
     {
         ?>
         <tr>
             <td colspan = "15" align ="center">Tidak ada data lelang</td>
         </tr>
         <?php
     }
      ?>
 </table>
