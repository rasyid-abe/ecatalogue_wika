define([
    "jQuery",
	"bootstrap4",
    "jqvalidate",
    "datatables",
    "noUiSlider",
    "select2",
	], function (
    $,
	bootstrap4,
    jqvalidate,
    datatables,
    noUiSlider,
    select2,
	) {
    return {
        init: function () {
        	App.initFunc();
            App.initEvent();
            App.changeCategory();
            App.filter();
            App.infiniteScroll();
            App.toggleFilter();
            console.log("loaded");
            $(".loadingpage").hide();
		},
        filter : function(){
          $('#btn-filter').on('click',function(){
            console.log($('#arr_location').val());
            //return;
            var vendor = [];
            var location = [];
            $('input[name^="vendor"]').each(function() {
              if($(this).is(':checked'))
              {
                  vendor.push($(this).val());
              }
              });
              /*
            $('input[name^="location"]').each(function() {
              if($(this).is(':checked'))
              {
                  location.push($(this).val());
              }
              });
              */
              vendor = vendor.join();
              location = $('#arr_location').val().join();
              var order_price = '';
              if($('#highprice').is(':checked') || $('#lowprice').is(':checked'))
              {
                order_price = $('#highprice').is(':checked') ? 'desc' : 'asc';
              }

            //console.log(location);
            var terkontrak = $('#terkontrak').is(':checked') ? 1 : 0;
            var tidak_terkontrak = $('#tidak_terkontrak').is(':checked') ? 1 : 0;
            //console.log(terkontrak)
            window.location.replace(App.baseUrl+'home?vendor='+vendor+'&location='+location+'&order='+order_price+'&terkontrak='+terkontrak+'&tidak_terkontrak='+tidak_terkontrak);
          });

          $('#highprice').on('click', function(){
            if($(this).is(':checked')) $('#lowprice').prop('checked',false);
          });
          $('#lowprice').on('click', function(){
            if($(this).is(':checked')) $('#highprice').prop('checked',false);
          });

        },

        initEvent : function(){
             $('*select[data-selectjs="true"]').select2({width: '100%'});

             $('#search-product').on('keydown', function(e){
                 if(e.keyCode == 13)
                 {
                     $('#btn-search-product').trigger('click');
                 }
             })
        },
        changeCategory : function(){
            $(".change-cat").on('click', function(){
                var pointer = $(this);
                $( ".change-cat" ).each(function( index ) {
                    $(this).removeClass('active');
                });
                pointer.addClass('active');
                $('#forScroll').html('');
                var page = $('#pageForScroll').val(0);
                var filter = $('#filterForScroll').val($(this).attr('value'));
                //if($('#btn-load-more').attr('style') != '')
                //$('#btn-load-more').attr('style','display:none');
                setTimeout(function(){
                    //$('#btn-load-more').removeAttr('style');
                },500);
                $('#btn-load-more').removeAttr('style');
                App.loadMore();
            });

            $('#btn-reset-filter').on('click',function(){
                $('#highprice').prop('checked', false);
                $('#lowprice').prop('checked', false);
                $('#rating').prop('checked', false);
                $('#popularity').prop('checked', false);
                $('#5rate').prop('checked', false);
                $('#4rate').prop('checked', false);
                $('#3rate').prop('checked', false);
                $('#2rate').prop('checked', false);
                $('#1rate').prop('checked', false);

                $('input[name^="vendor"]').each(function() {
                    $(this).prop('checked', false);
                  });

                $('input[name^="location"]').each(function() {
                    $(this).prop('checked', false);
                });
            });

            $('#btn-search-product').on('click', function(){
                $('#pageForScroll').val(0);
                $('#forScroll').html('');
                App.loadMore()
            });
        },

        loadMore : function(){
            var page = $('#pageForScroll').val();
            var filter = $('#filterForScroll').val();
            var search = $('#search-product').val();
            var q_string = location.search;
            $.ajax({
                url : App.baseUrl+'home/getNextProduct'+q_string,
                dataType : 'json',
                method : 'get',
                data : {
                    page : page,
                    category : filter,
                    search : search,
                },
                success : function(data){
                    $('#forScroll').append(data.product);
                    if(data.habis == 'tidak')
                    {
                        page++;
                    }
                    else
                    {
                        //alert(data.habis);
                        page++;
                        $('#btn-load-more').attr('style','display:none');
                    }
                    $('#pageForScroll').val(page);
                }
            });
        },

        infiniteScroll : function(){
            $('#btn-load-more').on('click', function(){
                App.loadMore();
            });
        },

        toggleFilter : function(){
            $("#btn-sort").click(function(){
              $("#filter").toggle();
            });
        },
	}
});
