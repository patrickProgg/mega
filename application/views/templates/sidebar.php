<style>
    .mega-text {
        font-family: "Old English Text MT", "Blackletter", serif;
        font-size: 28px;
        font-weight: bold;
        /* color: blue; */
    }
</style>
<section id="sidebar" class="preload">
    <a href="<?= base_url() ?>dashboard" class="brand">
        <img src="<?= base_url(); ?>assets/image/MEGA2.png" style="width: 40px;" />
        <!-- <i class='bx bx-command'></i> --> 
        <span class="text mega-text">MEGA</span>
    </a>

    <ul class="side-menu top">
        <li class="<?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
            <a href="<?= base_url() ?>dashboard">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>
        <li class="<?= ($this->uri->segment(1) == 'index') ? 'active' : '' ?>">
            <a href="<?= base_url() ?>index">
                <i class='bx bx-group'></i>
                <span class="text">Members</span>
                <!-- <span class="badge bg-danger rounded-pill" style="margin-left: 40px;">0 </span> -->
            </a>
        </li>
        <li class="<?= ($this->uri->segment(1) == 'payment') ? 'active' : '' ?>">
            <a href="<?= base_url() ?>payment">
                <i class='bx bx-donate-heart'></i>
                <span class="text">Mutual Aid</span>
            </a>
        </li>
        <li class="<?= ($this->uri->segment(1) == 'rental') ? 'active' : '' ?>">
            <a href="<?= base_url() ?>rental">
                <i class='bx bx-file'></i>
                <span class="text">Utility Assets</span>
            </a>
        </li>
        <li class="<?= ($this->uri->segment(1) == 'loan') ? 'active' : '' ?>">
            <a href="<?= base_url() ?>loan">
                <i class='bx bx-wallet'></i>
                <span class="text">Loan</span>
            </a>
        </li>
        <li class="<?= ($this->uri->segment(1) == 'Team') ? 'active' : '' ?>">
            <a href="#">
                <i class='bx bx-line-chart'></i>
                <span class="text">Investment</span>
            </a>
        </li>
        <li class="<?= ($this->uri->segment(1) == 'history') ? 'active' : '' ?>">
            <a href="<?= base_url() ?>history">
                <i class='bx bx-list-ul'></i>
                <span class="text">History</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li class="<?= ($this->uri->segment(1) == 'Settings') ? 'active' : '' ?>">
            <a href="#">
                <i class='bx bx-cog'></i>
                <!-- <img src="<?= base_url('assets/gif/settings1.gif'); ?>" style="width: 20px; height: 20px; margin-left: 10px;"> -->
                <!-- <span class="text" style="margin-left: 10px;">Settings</span> -->
                <span class="text">Settings</span>
            </a>
        </li>

        <li>
            <a href="<?= base_url('logout') ?>" class="logout" id="logout-link">
                <i class="bx bx-log-out"></i>

                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>

<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
    document.getElementById('logout-link').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default link behavior

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to log out?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, log out!',
            cancelButtonText: 'No, stay here!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = this.href; // Redirect to the logout URL
            }
        });
    });
</script>