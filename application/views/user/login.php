<div class="container">
    <div class="screen">
        <div class="screen__content">
            <form id="loginForm" class="login" action="<?= base_url('authenticate') ?>" method="POST">
                <div class="login__field">
                    <i class="login__icon fas fa-user"></i>
                    <input type="text" name="username_or_email" class="login__input" placeholder="User name / Email" required>
                </div>
                <div class="login__field">
                    <i class="login__icon fas fa-lock"></i>
                    <input type="password" name="password" class="login__input" placeholder="Password" required>
                </div>
                <button type="submit" id="loginButton" class="button login__submit">
                    <span class="button__text">Log In Now</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>
            </form>
            <!-- <div class="social-login">
                <h3>log in via</h3>
                <div class="social-icons">
                    <a href="#" class="social-login__icon fab fa-instagram"></a>
                    <a href="#" class="social-login__icon fab fa-facebook"></a>
                    <a href="#" class="social-login__icon fab fa-twitter"></a>
                </div>
            </div> -->
        </div>
        <div class="screen__background">
            <span class="screen__background__shape screen__background__shape4"></span>
            <span class="screen__background__shape screen__background__shape3"></span>
            <span class="screen__background__shape screen__background__shape2"></span>
            <span class="screen__background__shape screen__background__shape1"></span>
        </div>
    </div>

    <?php if ($this->session->flashdata('error')) { ?>
        <div class="custom-alert alert alert-danger position-absolute top-0 end-0 m-3" role="alert">
            Invalid username/email or password.
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('success')) { ?>
        <div class="custom-alert alert alert-success" role="alert">
            Successfully Added
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('deleted')) { ?>
        <div class="custom-alert alert alert-success" role="alert">
            Successfully Deleted
        </div>
    <?php } ?>
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="custom-alert alert alert-danger" role="alert">
            Failed!
        </div>
    <?php } ?>
</div>

<!-- Add SweetAlert script -->
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent immediate form submission

        // Swal.fire({
        //     title: 'Logging in...',
        //     text: 'Please wait while we verify your credentials.',
        //     icon: 'info',
        //     allowOutsideClick: false,
        //     showConfirmButton: false,
        //     didOpen: () => {
        //         Swal.showLoading(); // Show the loading spinner
        //     }
        // });

        // Simulate form submission with a short delay to show the loading
        // setTimeout(() => {
            loginForm.submit(); // Submit the form after the delay
        // }, 500); // Adjust delay if needed
    });
</script>
