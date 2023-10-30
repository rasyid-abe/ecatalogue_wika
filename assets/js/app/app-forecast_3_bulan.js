define([
    "jQuery",
    "jqvalidate",
    "bootstrap",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    "bootstrapDatepicker",
    "highchart",
    "Handsontable",
    "select2",
    ], function (
    $,
    jqvalidate,
    bootstrap,
    sidebar ,
    datatables,
    datatablesBootstrap,
    bootstrapDatepicker,
    highchart,
    Handsontable,
    select2
    ) {
    return {
        table:null,
        req:false,
        dummy : [
            [1,"Produk12 BJTP 24 Dia. 8 mm x 12 m",0,0,0,0,0,0,0,0,0,0],
            [2,"Produk12 BJTP 24 Dia. 8 mm x 12 m",0,0,0,0,0,0,0,0,0,0],
            [3,"Produk12 BJTP 24 Dia. 8 mm x 12 m",0,0,0,0,0,0,0,0,0,0],
            [4,"Produk12 BJTP 24 Dia. 8 mm x 12 m",0,0,0,0,0,0,0,0,0,0],
        ],
        init: function () {
            var container = window.document.getElementById('hot');
            App.hot = new Handsontable(container,{
                data : App.dummy,
                colHeaders : ['id_produk','nama_barang','bulan1','bulan2','bulan3','IP','PE','LN','SU1','SU2','SU3','Total'],
                cells :function(r,c)
                {
                        //console.log(r+''+c);
                        var cellProperties = {};
                        if(c == 1 || c ==0)
                        cellProperties.readOnly = true;

                        return cellProperties;
                },
                beforeChange : function(changes, source)
                {
                    if(source == 'edit')
                    {
                        if(isNaN(parseInt(changes[0][3])))
                        {
                            changes[0][3] = 0
                        }
                        else
                        {
                            changes[0][3] = parseInt(changes[0][3])
                        }

                    }
                },
                afterChange : function(changes, source)
                {
                    if(source == 'edit')
                    {
                        $.each(changes,function(i,e){
                           var tot = 0;
                           $.each(App.dummy[e[0]], function(a,b){
                               console.log(a+' '+b);
                               if(a != index_total && a !== 0 && a !== 1)
                               tot += b
                           })
                           App.dummy[e[0]][index_total] = tot;
                           //console.log(tot);
                        });

                        //data[0][5] = 20;
                        this.loadData(App.dummy);
                        //console.log(changes);
                    }
                },
            });
            var tambah_kolom = 0;
            var index_total = 11;
            var index_tambah = 5;
            $('#btn-plus').on('click',function(){
                App.hot.alter('insert_col', index_tambah);
                //console.log(data);
                index_total++;
                tambah_kolom++;
                index_tambah++;
                var col = App.hot.getColHeader();
                //return;
                col.splice(index_tambah - 1,1,'b_tambahan'+tambah_kolom);
                App.hot.updateSettings({
                    colHeaders : col,
                });
            });

            $('#btn-min').on('click',function(){
                console.log(App.hot.getData());
                //return;
                if(tambah_kolom == 0)
                {
                    alert('tidak bisa kurang lagi');
                    return;
                }

                App.hot.alter('remove_col', index_tambah - 1);
                index_total--;
                tambah_kolom--;
                index_tambah--;
                $.each(App.dummy, function(i,e){
                    var tot = 0;
                    $.each(e, function(a,b){
                        if(a != index_total && a !== 0 && a !== 1)
                        tot += b
                    });
                    App.dummy[i][index_total] = tot;
                });
                App.hot.loadData(App.dummy);
            });

            $(".loading").hide();
        },
    }
});
