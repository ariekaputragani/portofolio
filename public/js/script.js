(function ($) {

  "use strict";

    // PRE LOADER
    $(window).load(function(){
      $('.preloader').fadeOut(1000); // set duration in brackets

      $('#ads-b').hide();
      $('#ads-bx').hide();
      $('#ads-ba').hide();
      $('#ads-c1').hide();
      $('#ads-s1').hide();

      $('#ads-sd').hide();
      $('#ads-sdx').hide();
      $('#ads-sda').hide();
      $('#ads-c2').hide();
      $('#ads-s2').hide();

      setTimeout(function() {
        $('.lamcn').css("background-image","url('/images/gambar2.jpg')");
      }, 2000);

      setTimeout(function() {
        $('#ads-b').show();
        $('#ads-bx').show();
      }, 3000);

      setTimeout(function() {
        $('#ads-sd').show();
        $('#ads-sdx').show();
      }, 3700);
    });

    function closeAd1() {
        $('#ads-b').hide();
        $('#ads-bx').hide();
        $('#ads-ba').show();
        $('#ads-s1').show();
        setTimeout(function() {
          $('#ads-s1').hide();
          $('#ads-c1').show();
        }, 1000);
    }

    function closeAd2() {
        $('#ads-sd').hide();
        $('#ads-sdx').hide();
        $('#ads-sda').show();
        $('#ads-s2').show();
        setTimeout(function() {
          $('#ads-s2').hide();
          $('#ads-c2').show();
        }, 1000);
    }

    $(function () {
      $('#ads-bx').click(function (e) {
        e.preventDefault();
        closeAd1();
      });
      $('#ads-sdx').click(function (e) {
        e.preventDefault();
        closeAd2();
      });
      var today = new Date().toISOString().split("T")[0];
      $('.select2').select2({
        placeholder: "Pilih beberapa tag"
      });
      $('#birthdate').attr("max", today);
      $('#date').attr("min", today);
      $('#addtag').click(function() {
        (async () => {
          const{ value:formValues} = await Swal.fire({
            title: 'Buat Tag Baru',
            input: 'text',
            inputPlaceholder: 'Masukkan Tag',
            inputAttributes: {
              'id': 'name',
              'required': 'true'
            },
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33',
            inputValidator: (value) => {
              if(!value) {
                return 'Masukkan tag yang benar!';
              }
            }
          })
          
          if(formValues){
            var data = {
              name: $('#name').val(),
            };
          
            $.ajax( {
              url: '/tags/store',
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: data,
              success:function() {
                Swal.fire({
                  icon: 'success',
                  title: 'Tag berhasil dibuat!'
                });
                $('#tag').load('/tag-input')
              },
              error:function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Masukkan tag yang benar!'
                })
              }
            })
          }
        })()
      });
      $('#editname').click(function() {
        (async () => {
          const{ value:formValues} = await Swal.fire({
            title: 'Edit Nama',
            input: 'text',
            inputPlaceholder: 'Masukkan Nama',
            inputAttributes: {
              'id': 'name',
              'required': 'true'
            },
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33',
            inputValidator: (value) => {
              if(!value) {
                return 'Masukkan nama yang benar!';
              }
            }
          })
          if(formValues){
            var data = {
              name: $('#name').val(),
            };
          
            $.ajax( {
              url: '/profile/edit',
              type: 'patch',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: data,
              success:function() {
                Swal.fire({
                  icon: 'success',
                  title: 'Nama berhasil diubah!'
                });
              },
              error:function() {
                Swal.fire({
                  icon: 'success',
                  title: 'Nama berhasil diubah!'
                })
              }
            })
          }
        })()
      });
      $('#editemail').click(function() {
        (async () => {
          const{ value:email} = await Swal.fire({
            title: 'Edit Email',
            input: 'email',
            inputPlaceholder: 'Masukkan Email',
            inputAttributes: {
              'id': 'email',
              'required': 'true'
            },
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33',
            inputValidator: (value) => {
              if(!value) {
                return 'Masukkan email yang benar!';
              }
            }
          })
          if(email){
            var data = {
              name: $('#name').val(),
            };
          
            $.ajax( {
              url: '/profile/edit',
              type: 'patch',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: data,
              success:function() {
                Swal.fire({
                  icon: 'success',
                  title: 'Email berhasil diubah!'
                });
              },
              error:function() {
                Swal.fire({
                  icon: 'success',
                  title: 'Email berhasil diubah!'
                })
              }
            })
          }
        })()
      });
      $('.addjanji').click(function() {
        (async () => {
          const{ value:formValues} = await Swal.fire({
            title: 'Buat Janji',
            html:
            '<label for="name_a" class="swal2-input-label">Nama</label>' +
            '<input class="swal2-input" type="text" id="name_a" name="name_a" placeholder="Masukkan Nama Lengkap">' +
            '<label for="email_a" class="swal2-input-label">Email</label>' +
            '<input class="swal2-input" type="email" id="email_a" name="email_a" placeholder="Masukkan Email">' +
            '<label for="date" class="swal2-input-label">Pilih Tanggal</label>' +
            '<input class="swal2-input" type="date" id="date" name="date">' +
            '<label for="departement" class="swal2-input-label">Pilih Departemen</label>' +
            '<select class="swal2-select" id="departement" name="departement">' +
            '<option value="Kesehatan Umum">Kesehatan Umum</option>' +
            '<option value="Kardiologi">Kardiologi</option>' +
            '<option value="Kedokteran Gigi">Kedokteran Gigi</option>' +
            '<option value="Penelitian Medis">Penelitian Medis</option>' +
            '<option value="Nefrologi">Nefrologi</option>' +
            '</select>' +
            '<label for="phone_a" class="swal2-input-label">Nomor Telepon</label>' +
            '<input class="swal2-input" type="text" id="phone_a" name="phone_a" placeholder="Masukkan Nomor Telepon">' +
            '<label for="message_a" class="swal2-input-label">Pesan Tambahan</label>' +
            '<textarea class="swal2-input" rows="5" id="message_a" name="message_a" placeholder="Pesan"></textarea>',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#d33'
          })
          if(formValues){
            var data = {
              name: $('#name_a').val(),
              email: $('#email_a').val(),
              date: $('#date').val(),
              departement: $('#departement').val(),
              phone: $('#phone_a').val(),
              message: $('#message_a').val(),
            };
          
            $.ajax( {
              url: '/appointments/store',
              type: 'post',
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
              data: data,
              success:function() {
                Swal.fire({
                  icon: 'success',
                  title: 'Janji berhasil dibuat!'
                });
              },
              error:function() {
                Swal.fire({
                  icon: 'error',
                  title: 'Masukkan data yang benar!'
                })
              }
            })
          }
        })()
      });
    });


    //Navigation Section
    $('.navbar-collapse a').on('click',function(){
      $(".navbar-collapse").collapse('hide');
    });


    $('.owl-carousel').owlCarousel({
      animateOut: 'fadeOut',
      items:1,
      loop:true,
      autoplay:true,
    })

    // PARALLAX EFFECT
    $.stellar();  

    // SMOOTHSCROLL
    $(function() {
      $('nav a, #home a, footer a').on('click', function(event) {
        var $anchor = $(this);
          $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 49
          }, 1000);
            event.preventDefault();
      });
    });  


    // WOW ANIMATION
    new WOW({ mobile: false }).init();

})(jQuery);
