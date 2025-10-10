<?php $title = "Register"; ?>

<?php ob_start(); ?>
<main class="bg-light vh-100 row align-items-center justify-content-center">
  <div class="container bg-white p-4 rounded shadow my-auto col-md-6 d-flex flex-column align-items-center w-50">
    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mb-4 p-3 text-white" style="width: 75px; height: 75px;">
      <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 640 640"><path d="M451.5 160C434.9 160 418.8 164.5 404.7 172.7C388.9 156.7 370.5 143.3 350.2 133.2C378.4 109.2 414.3 96 451.5 96C537.9 96 608 166 608 252.5C608 294 591.5 333.8 562.2 363.1L491.1 434.2C461.8 463.5 422 480 380.5 480C294.1 480 224 410 224 323.5C224 322 224 320.5 224.1 319C224.6 301.3 239.3 287.4 257 287.9C274.7 288.4 288.6 303.1 288.1 320.8C288.1 321.7 288.1 322.6 288.1 323.4C288.1 374.5 329.5 415.9 380.6 415.9C405.1 415.9 428.6 406.2 446 388.8L517.1 317.7C534.4 300.4 544.2 276.8 544.2 252.3C544.2 201.2 502.8 159.8 451.7 159.8zM307.2 237.3C305.3 236.5 303.4 235.4 301.7 234.2C289.1 227.7 274.7 224 259.6 224C235.1 224 211.6 233.7 194.2 251.1L123.1 322.2C105.8 339.5 96 363.1 96 387.6C96 438.7 137.4 480.1 188.5 480.1C205 480.1 221.1 475.7 235.2 467.5C251 483.5 269.4 496.9 289.8 507C261.6 530.9 225.8 544.2 188.5 544.2C102.1 544.2 32 474.2 32 387.7C32 346.2 48.5 306.4 77.8 277.1L148.9 206C178.2 176.7 218 160.2 259.5 160.2C346.1 160.2 416 230.8 416 317.1C416 318.4 416 319.7 416 321C415.6 338.7 400.9 352.6 383.2 352.2C365.5 351.8 351.6 337.1 352 319.4C352 318.6 352 317.9 352 317.1C352 283.4 334 253.8 307.2 237.5z"/></svg>
    </div>
    <h1 class="mb-4">Gestion des familles adhérentes</h1>
    <p class="mb-4 text-secondary">Veuillez vous inscrire pour accéder à votre compte.</p>
    <form method="POST" action="/api/register" class="w-100">
      <div class="mb-3">
        <label for="username" class="form-label">Nom d'utilisateur <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="username" name="username" required>
        <p class="invalid-feedback text-danger"></p>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" id="email" name="email" required>
        <p class="invalid-feedback text-danger"></p>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="password" name="password" required>
        <p class="invalid-feedback text-danger"></p>
      </div>
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        <p class="invalid-feedback text-danger"></p>
      </div>
      <div class="mb-3 d-flex justify-content-center">
        <button type="submit" class="btn btn-primary w-50">S'inscrire</button>
      </div>
      <div class="alert alert-danger error d-none" role="alert">
      </div>
      <div class="w-100 text-end">
        <p class="mt-3">Vous avez déjà un compte ? <a href="/connexion">Connectez-vous</a></p>
      </div>
    </form>
  </div>

  <script>
    $(document).ready(()=>{
      let $form = $('form');
      let $btn = $('button[type="submit"]');

      $('#confirm_password').on('input', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();

        const ok = password === confirmPassword;
        $('#confirm_password').toggleClass('is-invalid', !ok);
        if (!ok) {
          $(this).siblings('.invalid-feedback').text('Les mots de passe ne correspondent pas.');
        } else {
          $(this).siblings('.invalid-feedback').text('');
        }
      });

      $form.on('submit', (e)=>{
        e.preventDefault();
        $btn.prop('disabled', true).text('Inscription...').removeClass('btn-primary').addClass('btn-secondary');
        $form.find('.error').addClass('d-none').text('');

        $.ajax({
          url: $form.attr('action'),
          method: $form.attr('method'),
          data: $form.serialize(),
        })
          .done((response) => {
            const isSuccess = response && response.success === true;
            if (isSuccess) {
              window.location.href = '/';
            } else {
              $btn.prop('disabled', false).text("S'inscrire").removeClass('btn-secondary').addClass('btn-primary');
              const message = response && response.message ? response.message : 'Une erreur est survenue. Veuillez réessayer.';
              $form.find('.error').text(message).removeClass('d-none');
            }
          })
          .fail((xhr, status, error) => {
            $btn.prop('disabled', false).text("S'inscrire").removeClass('btn-secondary').addClass('btn-primary');
            const errorResponse = xhr.responseJSON;
            const message = errorResponse && errorResponse.message ? errorResponse.message : 'Une erreur est survenue. Veuillez réessayer.';
            $form.find('.error').text(message).removeClass('d-none');
          });
      });
    });
  </script>
</main>

<?php $content = ob_get_clean(); ?>

<?php require('src/layout/main.php') ?>
