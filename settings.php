<?php
require_once 'inc/dbh.inc.php';
require_once 'inc/Auth/auth.php';
require_once 'header.php';
if (!isset($_SESSION['token'])) {
  echo "<div class='alert alert-info w-75 text-center mx-auto mt-5'>
          <h4>You need to login to access this</h4>
        </div>";
  die();
}
$query = "SELECT * FROM `users` WHERE `idusers`=" . $_SESSION['userId'] . "";
$result = $conn->query($query)->fetch_assoc();
if (!is_null($_SESSION['profile-pic'])) {
  $prmimg = $_SESSION['profile-pic'];
} else {
  $prmimg = 'default.jpg';
}
$user_id = $_SESSION['token'];
?>
<style>
  @media screen and (min-width: 600px) {
    body {
      overflow-y: hidden;
    }

    .settings-main {
      overflow-y: scroll;
      height: calc(100vh - 50px);
    }
  }
</style>

<div class="row co">
  <div class="col-sm-3 settings-sidebar sidebar-sticky border-right p-0">
    <a href="?profile" class="page-link tab_bg border-bottom active">
      <div class="settings-option text-left">
        <h3 class="co ml-4">profile</h3>
      </div>
    </a>
    <a href="?appearance" class="page-link tab_bg border-bottom">
      <div class="settings-option text-left">
        <h3 class="co ml-4">appearance</h3>
      </div>
    </a>
    <a href="?password" class="page-link tab_bg border-bottom">
      <div class="settings-option text-left">
        <h3 class="co ml-4">password</h3>
      </div>
    </a>
    <a href="?delete" class="page-link tab_bg border-bottom">
      <div class="settings-option text-left">
        <h3 class="co ml-4">delete account</h3>
      </div>
    </a>

    <a href="?developer" class="page-link tab_bg border-bottom">
      <div class="settings-option text-left">
        <h3 class="co ml-4">advanced</h3>
      </div>
    </a>
    <a href="inc/logout.inc.php" onclick="sessionStorage.clear();sessionStorage.setItem('load', true)" class="page-link tab_bg border-bottom">
      <div class="settings-option text-left">
        <h3 class="co ml-4">logout</h3>
      </div>
    </a>
  </div>
  <div class="col-sm-9 settings-main">


    <?php

    if (isset($_GET['appearance'])) {
      // this is where user can change app themes and other settings
    ?>
      <div class="settings-header mt-4">
        <h2 class="co">appearance</h2>
      </div>
      <div class="settings-body pt-2">
        <h3 class="co">app theme</h3>
        <div class="row w-75 mx-auto text-left my-2 pt-2">
          <label for="theme" class="col-6 co">Select theme</label>
          <select id="theme" class="col-4" name="chat-theme">
            <option value="none" disabled selected>default</option>
            <option value="light">light</option>
            <option value="dark">dark</option>
          </select>
        </div>
        <div class="row w-75 mx-auto text-left my-2 pt-2 align-items-center ">
          <span for="color" class="col-6 co">Accent color <span class="small text-muted">(dark mode)</span> </span>
          <input type="color" name="huntry" id="color" value="#6c5ce7" class="border-0 mx-2 bg-transparent ">
          <button id="apply-color" class="btn bg mx-2" onclick="location.reload()">aply</button>
          <button id="reset-color" class="btn excl btn-outline-info mx-2">reset</button>
        </div>
      </div>
    <?php

    } else if (isset($_GET['developer'])) {
      // developer page
    ?>
      <div class="settings-content py-5 mt-4">
        <h2 class="co">Developer</h2>
        <div class="mt-4">
          <label for="developer-dashboard" class="form-label">Developer Dashboard</label>
          <p class="text-muted">Access the developer dashboard for API and Bot features.</p>
          <a href="./api/developer/">
            <button id="developer-dashboard" class="btn text-white bg">
              <i class="fa text-white  fa-code"></i> Go to Developer Dashboard
            </button></a>
        </div>
      </div>

    <?php
    } else if (isset($_GET['delete'])) {
      // delete account page
    ?>

      <div class="settings-header py-4">
        <h2 class="co">delete account</h2>
      </div>
      <?php
      if (isset($_GET['err']) && $_GET['err'] == 'wrongpassword') {
        echo '<div class="alert alert-danger" role="alert">
        <strong>Error!</strong> wrong password.
      </div>';
      }
      ?>
      <div class="settings-body">
        <form action="inc/delete.inc.php" method="POST" class="w-75 mx-auto text-left">
          <div class="form-group">
            <label for="delete-user">type your password</label>
            <!-- use bootstrap tooltips -->

            <input type="password" class="form-control w-100 delete-user" name="user" id="delete-user">
          </div>
          <button type="submit" name='delete_profile' class="btn btn-danger delete-btn" disabled>Delete</button>
        </form>
      </div>
    <?php
    } else if (isset($_GET['password'])) {
      // password page
    ?>
      <div class="settings-header py-4">
        <h2 class="co">change password</h2>
      </div>
      <?php
      if (isset($_GET['err']) && $_GET['err'] == 'wrongpassword') {
        echo '<div class="alert alert-danger" role="alert">
        <strong>Error!</strong> wrong password.
      </div>';
      }
      if (isset($_GET['success']) && $_GET['success'] == 'passwordchanged') {
        echo '<div class="alert alert-success" role="alert">
        <strong>Success!</strong> Password changed successfully.
      </div>';
      }
      ?>
      <div class="settings-body">
        <form action="inc/settings.inc.php" method="POST" class="w-75 mx-auto text-left">
          <div class="form-group">
            <label for="current-password">Current password</label>
            <input type="password" class="form-control w-100 submit" name="current" id="current-password">
          </div>
          <div class="form-group">
            <label for="new-password">New password</label>
            <input type="password" class="form-control w-100 submit" name="newpass" id="new-password">
          </div>
          <button type="submit" name="password_change" class="btn bg post-btn">Save</button>
        </form>
      </div>
    <?php
    } else {
      // settings page
      if (isset($_GET["error"])) {
        echo '<div id="email-v" class="alert alert-danger text-center py-2 my-1  w-75 mx-auto" role="alert">
        <p>An error occured, data not updated.</p>
      </div>';
      }
      if (isset($_GET["success"])) {
        echo '<div id="email-v" class="alert alert-success text-center py-2 my-1  w-75 mx-auto" role="alert">
        <p>your info has been updated.</p>
      </div>';
      }

    ?>
      <div class="settings-header py-4">

        <h2 class="co">settings</h2>
      </div>
      <div class="settings-body">
        <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="profile-pic" class="profile-pic shadow-sm">
              <img src="img/<?php echo $prmimg; ?>" alt="profile-pic" class="img-thumbnail" onerror="this.error = null; this.src ='img/default.jpg' " style="background-size: cover; width: 120px;height: 120px; border-radius: 50%;">
            </label>
            <input type="file" title="change profile pic" accept=".png,.gif,.jpg,.webp" name="file" id="profile-pic" style="display: none;" data-toggle="tooltip" data-placement="top" title="click to select image" required /><br>
          </div>
          <button class="btn profile-btn bg" for="profile-pic" type="submit" style="width: fit-content;margin: 0 auto;" data-toggle="tooltip" data-placement="bottom" title="click above image to upload" disabled>change profile
            picture</button>

        </form>
        <br><br>
        <form action="inc/settings.inc.php" method="POST" class="w-75 mx-auto mb-4 text-left">
          <div class="form-group">
            <label for="username" data-toggle="tooltip" data-placement="top" title="usernane cannot be changed">username<sup class="text-danger">*</sup> </label>
            <input type="text" class="form-control w-100" name="username" id="username" value="<?= $_SESSION['userUid']; ?>" disabled>
          </div>
          <div class="form-group">
            <label for="fname">First name</label>
            <input type="text" class="form-control w-100" name="firstname" id="fname" value="<?php echo $result['usersFirstname']; ?>">
          </div>
          <div class="form-group">
            <label for="sname">Second name</label>
            <input type="text" class="form-control w-100" name="lastname" id="sname" value="<?php echo $result['usersSecondname']; ?>">
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <div class="input-group">
              <input type="email" class="form-control" name="email" id="email" value="<?php echo $result['emailusers']; ?>">
              <?php
              if (!$un_ravel->_isEmail_verified($user_id) && !empty($result['emailusers']) && EMAIL_VERIFICATION) {
              ?>
                <button type="button" class="btn <?= $un_ravel->_isEmail_verified($user_id) ? "bg-success" : "bg" ?>" id="send-v" style="display: none;">
                  Verify
                </button>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label for="bio">Bio</label>
            <textarea name="bio" id="bio" cols="30" rows="10" placeholder="enter your bio here...." title="not more than 200 words" maxlength="200" class="form-control w-100"><?php echo $result['bio']; ?></textarea>
          </div>

          <button type="submit" name="profile_btn" class="btn bg post-btn btn-lg">Save</button>
        </form>
      </div>


    <?php
    }
    ?>

  </div>
</div>

<?php
require 'footer.php';
?>



<script>
  $(document).ready(function() {

    // generate a preview of the image
    $('#profile-pic').change(function() {
      var input = this;
      $('.img-thumbnail').attr('disabled', false);
      $('#uploadimage').submit();
      var url = $(this).val();
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg" || ext == "webp")) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('.img-thumbnail').attr('src', e.target.result);
          $('.img-thumbnail').css('background-image', 'none');
        }
        reader.readAsDataURL(input.files[0]);
      }
    });

    $('#uploadimage').submit(function(e) {
      e.preventDefault();
      // set profile-btn to loading
      $('.profile-btn').html('preparing...');
      // #profile-pic file is not selected
      if ($('#profile-pic').val() == '') {
        $('#img-thumbnail').css('border', '1px solid red');
        alert('Please select a file');
        $('.profile-btn').html('upload failed');
        // set back to danger
        $('.profile-btn').css('background', '#dc3545');
        return false;
      }
      // 
      //
      var image_name = $('#profile-pic').val();
      var extension = $('#profile-pic').val().split('.').pop().toLowerCase();
      if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
        $('.profile-btn').html('invalid image');
        $('.profile-btn').css('background', '#dc3545');
        $('#profile-pic').val('');
        return false;
      } else {
        var form_data = new FormData(this);
        $.ajax({
          url: "./inc/profile-pic.inc.php",
          type: "POST",
          data: form_data,
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('.profile-btn').html('uploading...');
          },
          success: function(data) {
            $('.profile-btn').html('uploaded');
            setTimeout(function() {
              $('.profile-btn').css('background', '#28a745');
            }, 1000);

          }
        });
      }


    });


    jQuery(document).ready(function() {

      $('.input').each(function() {
        this.addEventListener('input', showBtn)

      })

      function showBtn() {
        $('.submit').attr('disabled', false);
      }

      $(function() {
        $('[data-toggle="tooltip"]').tooltip();
      });


    });
    $('#theme').change(function() {
      var theme = $(this).val();
      localStorage.setItem('theme', theme);
      window.location.reload();
    });


    $('#color').change(function() {
      var color = $(this).val();
      localStorage.setItem('color', color);
      $("#apply-color").css('background', color);
    });
    $('#reset-color').click(function() {
      $('#color').val("#6c5ce7")
      localStorage.removeItem('color');
    })

    if (localStorage.getItem('color')) {
      $('#color').val(localStorage.getItem('color'))
    }

    $('.delete-user').on('input', function() {
      if ($('.delete-user').val() != '') {
        $('.delete-btn').attr('disabled', false);
      } else {
        $('.delete-btn').attr('disabled', true);
      }
    })
  });

  if (sessionStorage.getItem('send_click') == null) {
    $('#send-v').show();
  }
  $('#send-v').click(function() {
    $.get('inc/send_verification.php?id=' + '<?= $_SESSION['token'] ?>', function(data) {
      if (data) {
        alert("verification email sent");
        sessionStorage.setItem('send_click', 'true');
        $('#send-v').hide();
      }
    });
  });
</script>