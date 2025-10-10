<?php $title = "Login"; ?>

<?php ob_start(); ?>
<main class="bg-light vh-100 row align-items-center justify-content-center">
  <div class="container bg-white p-4 rounded shadow my-auto col-md-6 d-flex flex-column align-items-center w-50">
    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mb-4 p-3 text-white" style="width: 75px; height: 75px;">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" fill="currentColor"><path d="M409 337C418.4 327.6 418.4 312.4 409 303.1L265 159C258.1 152.1 247.8 150.1 238.8 153.8C229.8 157.5 224 166.3 224 176L224 256L112 256C85.5 256 64 277.5 64 304L64 336C64 362.5 85.5 384 112 384L224 384L224 464C224 473.7 229.8 482.5 238.8 486.2C247.8 489.9 258.1 487.9 265 481L409 337zM416 480C398.3 480 384 494.3 384 512C384 529.7 398.3 544 416 544L480 544C533 544 576 501 576 448L576 192C576 139 533 96 480 96L416 96C398.3 96 384 110.3 384 128C384 145.7 398.3 160 416 160L480 160C497.7 160 512 174.3 512 192L512 448C512 465.7 497.7 480 480 480L416 480z"/></svg>
    </div>
    <h1 class="mb-4">Gestion des familles adhérentes</h1>
    <p class="mb-4 text-secondary">Veuillez vous connecter pour accéder à votre compte.</p>
    <form class="w-100">
      <div class="mb-3">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="email" name="email" required>
        <p class="invalid-feedback text-danger"></p>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="password" name="password" required>
        <p class="invalid-feedback text-danger"></p>
      </div>
      <div class="mb-3 d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-50">Se connecter</button>
      </div>
      <div class="alert alert-danger error d-none" role="alert">
      </div>
      <div class="w-100 text-end">
        <p class="mt-3">Vous n'avez pas de compte ? <a href="/inscription">Inscrivez-vous</a></p>
      </div>
    </form>
  </div>

  <script>
    $(document).ready(()=>{
      let $form = $('form');
      let $btn = $('button[type="submit"]');
      $form.on('submit', (e)=>{
        e.preventDefault();
        $btn.prop('disabled', true).text('Connexion...').removeClass('btn-primary').addClass('btn-secondary');

        $.ajax({
          url: '/api/login',
          method: 'POST',
          data: $form.serialize(),
          dataType: 'json',
        })
          .done((response) => {
            if (response.success) {
              window.location.href = '/';
            } else {
              $btn.prop('disabled', false).text('Connexion').removeClass('btn-secondary').addClass('btn-primary');
              $form.find('.error').text(response.message).removeClass('d-none');
            }
          })
          .fail((xhr, status, error) => {
            $btn.prop('disabled', false).text('Connexion').removeClass('btn-secondary').addClass('btn-primary');
            $form.find('.error').text('Une erreur est survenue.').removeClass('d-none');
          });
      });
    });
  </script>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('src/layout/main.php') ?>