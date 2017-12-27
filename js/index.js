$(document).ready(function() {

  // brisanje komentara
  $('body').on('click', '#btn_del_com', function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    console.log(id);
    $('.win-container').css('visibility', 'visible');
    $('.win-container').css('opacity', '1');
    $('.win-container form').attr('action', 'product_details.php?product_id=24');
    $('.win-container form').attr('method', 'post');
    $('#sakriveno-polje').attr('name', 'com_id');
    $('#sakriveno-polje').val(id);
    $('#delete-comment').attr('name', 'btn_del_com');
    $('.win-container .win p').html("Da li ste sigurni da zelite da obrisete komentar ID: " + id + '.');
  });

  $('#cancel-win').click(function(e) {
    e.preventDefault();
    $('.win-container').css('visibility', 'hidden');
    $('.win-container').css('opacity', '0');
  });


  // klikom na sliku
  $('#img_to_edit').click(function() {
    // slika nestaje
    $('#img_to_edit').slideUp();
    // pojavljuje se polje za izbor druge slike
    $('#edit_img_input').slideDown();
    // simulira se klik na input polje za izbor slike
    $('#edit_img_input #inputImage').click();
  });

  // aktivira podrsku za tooltipove
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
  // aktivira podrsku za popover
  $(function () {
    $('[data-toggle="popover"]').popover()
  });

  // saceka 5sec, zatim sakrije alert
  setTimeout(function() {
    $('.alert').slideUp();
  }, 5000);

  // proverava da li na stranici postoji elemenat
  // sa IDjem inputUsernameRegister
  if ( $('#inputUsernameRegister').length ) {

    // kada se napusti input polje
    $('#inputUsernameRegister').blur(function() {
      // pravi se http zahtev ka serveru koji proverava da
      // li je korisnicko ime slobodno
      $.ajax({
        url: './api.service.php',
        type: 'post',
        data: {
          // za koje korisnicko ime ispitujemo
          username: $('#inputUsernameRegister').val()
        },
        success: function(res) {
          // ovaj blok koda se izvrsava ukoliko je stranica
          // uspesno kontaktirala server

          // provera da li posoji username_taken property
          // u odgovoru servera
          if(res.hasOwnProperty('username_taken')) {

            // ispituje da li je korisnicko ime zauzeto
            if (res.username_taken == true) {

              // ako jeste zauzeto
              $('#usernameRegisterMessage')
              // 1. skida klasu text-success (ako postoji)
              .removeClass('text-success')
              // 2. dodaje klasu text-danger
              .addClass('text-danger')
              // 3. upisuje poruku u elementu
              .html("Username is already taken.");
            } else {
              $('#usernameRegisterMessage')
              .removeClass('text-danger')
              .addClass('text-success')
              .html("Username is available.");
            }
          }
        },
        error: function(error) {
          // ovaj blok koda se izvrsava ukoliko je doslo
          // do greske prlikom kontaktiranja servera
          // i ispisuje razlog u konzoli (F12)
          console.log(error);
        }
      });
    });
  }

  // isto za proveru e-mail adrese
  if ( $('#inputEmailRegister').length ) {

    var emailCheck;

    $('#inputEmailRegister').on('input', function() {
      clearTimeout(emailCheck);
      emailCheck = setTimeout(function() {
        console.log('Checking if email is available...');
        $.ajax({
          url: './api.service.php',
          type: 'post',
          data: {
            email: $('#inputEmailRegister').val()
          },
          success: function(res) {
            if(res.hasOwnProperty('email_taken')) {
              if (res.email_taken == true) {
                $('#emailRegisterMessage')
                .removeClass('text-success')
                .addClass('text-danger')
                .html("E-mail is already in database.");
              } else {
                $('#emailRegisterMessage')
                .removeClass('text-danger')
                .addClass('text-success')
                .html("E-mail is available.");
              }
            }
          },
          error: function(err) {
            console.log(err)
          }
        });
      }, 1000);
    });

  }

});
