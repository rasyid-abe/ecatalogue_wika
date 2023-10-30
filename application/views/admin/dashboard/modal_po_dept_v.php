<style>
    table.table-modal{
        border-collapse: collapse;
    }
    .table-modal td, .table-modal th{
        padding : 10px;
    }
</style>
<div class="modal fade" id="modal_po_dept">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form id="form_amandemen_product" method="POST">
            <div class="modal-body alert-msg">
                <div class="box-body">
                    <h3 class="text-center judul">
                        {NAMA PROJECT - NOMOR AMANDEMEN}
                    </h3>
                    <div class="row">
                        <div class="col-md-12" style="max-height: 500px;
                        overflow: auto;">
                            <table class="table-modal" border="1" width="100%">
                             <thead>
                               <tr style="background: black; color:white; font-size: 16px;">
                                   <th style="text-align: center">No Order</th>
                                   <th style="text-align: center">Nama Vendor</th>
                                   <th style="text-align: center">Volume (Kg)</th>
                                   <th style="text-align: center">Nominal (Rp)</th>
                               </tr>
                             </thead>
                             <tbody>
                             </tbody>
                           </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-default alert-cancel" data-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
  </div>
</div>
