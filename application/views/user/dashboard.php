<style>
    .box-info {

        padding: 0;

    }

    .order {
        background-color: rgba(255, 255, 255, 0.6);
    }

    /* class="order" style="background-color: rgba(255, 255, 255, 0.6);" */
    .box-info-li {
        background-image: url('<?= base_url('assets/image/db.jpg'); ?>');
        background-size: cover;
        background-position: center;
    }

    /* body {
		background: var(--grey);
		background-image: url('<?= base_url('assets/image/db.jpg'); ?>');
		background-size: cover;
		background-position: center;
	} */

    .box-info li {
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    }

    .box-info li:hover {
        transition: all 0.3s ease-in-out;
        cursor: pointer;
        transform: scale(1.05) translateY(-5px);
        background-color: rgba(0, 0, 0, 0.2);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    }

    ::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }
</style>

<body>
    <section id="content">
        <!-- MAIN -->
        <main>
            <!-- <div class="head-title" style="background-image: url('<?= base_url('assets/image/db.jpg'); ?>'); background-size: cover; background-position: center; padding:40px; border-radius:20px;"> -->
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <!-- <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <li><i class='bx bx-chevron-right'></i></li>
                    <li>
                        <a class="active" href="#">Home</a>
                    </li>
                </ul> -->
                </div>
                <a href="#" class="btn-download">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Download PDF</span>
                </a>
            </div>

            <ul class="box-info">
                <!-- <li style="background-color: rgba(255, 255, 255, 0.6);"> -->
                <!-- <li style="background-image: url('<?= base_url('assets/image/2.png'); ?>'); background-size: cover; background-position: center;"> -->
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?= $total_members ?></h3>
                        <p>Total Members</p>
                    </span>
                </li>

                <!-- <li style="background-image: url('<?= base_url('assets/image/3.png'); ?>'); background-size: cover; background-position: center;"> -->
                <li>
                    <i class='bx bxs-user-x'></i>
                    <span class="text">
                        <h3><?= $total_late_members ?></h3>
                        <p>Late Members</p>
                    </span>
                </li>

                <!-- <li style="background-color: rgba(255, 255, 255, 0.6);"> -->
                <!-- <li style="background-image: url('<?= base_url('assets/image/5.png'); ?>'); background-size: cover; background-position: center;"> -->
                <li>
                    <i class='bx bx-coin-stack'></i>
                    <!-- <img src="<?= base_url('assets/gif/money1.gif'); ?>" style="width: 100px; height: 100px;"> -->
                    <span class="text">
                        <h3>₱<?= number_format($total_fund, 2) ?></h3>
                        <p>Total Fund</p>
                    </span>
                </li>

                <!-- <li style="background-color: rgba(255, 255, 255, 0.6);"> -->
                <!-- <li style="background-image: url('<?= base_url('assets/image/4.png'); ?>'); background-size: cover; background-position: center;"> -->
                <li>
                    <i class='bx bxs-dollar-circle'></i>
                    <span class="text">
                        <h3>₱<?= number_format($total_rent_revenue, 2) ?></h3>
                        <p>Rental Revenue</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-dollar-circle'></i>
                    <span class="text">
                        <h3>₱<?= number_format($total_rent_revenue, 2) ?></h3>
                        <p>Rental Revenue</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Recently Added</h3>
                        <!-- <i class='bx bx-search'></i>
                    <i class='bx bx-filter'></i> -->
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>FULL NAME</th>
                                <th>DATE JOINED</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($details as $row) { ?>
                                <tr>
                                    <td><?= $row['full_name'] ?></td>
                                     <td><?=$row['date_joined']?></td>
                                    <td>
                                        <?php
                                        if ($row['status'] == 1) {
                                            echo '<span class="badge bg-danger">Inactive</span>';
                                        } elseif ($row['status'] == 2) {
                                            echo '<span class="badge bg-secondary">Deceased</span>';
                                        } else {
                                            echo '<span class="badge bg-success">Active</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
                <div class="todo">
                    <!-- <div class="modal-content" style="border:none; background: var(--light);"> -->
                    <div class="head">
                        <div class="order" style="border:none; background: var(--light);">
                            <div class="head">
                                <h3>Outstanding Benefits</h3>
                                <!-- <i class='bx bx-plus'></i>
                    <i class='bx bx-filter'></i> -->
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>FULL NAME</th>
                                        <th>PASSING DATE</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($late_details as $row) { ?>
                                        <tr>
                                            <td><?= $row['full_name'] ?></td>
                                            <td><?= date('M. j, Y', strtotime($row['dd_date_died'])) ?></td>
                                            <td>
                                                <?php
                                                if ($row['dd_status'] == 0) {
                                                    echo '<span class="badge bg-danger">Pending</span>';
                                                } else if ($row['dd_status'] == 1) {
                                                    echo '<span class="badge bg-primary">Partial</span>';
                                                } else {
                                                    echo '<span class="badge bg-success">Settled</span>';
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
</body>

<?php if ($this->session->flashdata('login_success')): ?>
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1050; width:800px;">
        <div id="loginAlert" class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: rgba(255, 255, 255, 0.6);">
            <h4 class="alert-heading">Hola!</h4>
            <p>Hey <?php echo $this->session->flashdata('login_success'); ?> good day! Ready to accomplish great things?</p>
        </div>
    </div>
<?php endif; ?>


<script>
    setTimeout(function() {
        let alert = document.getElementById('loginAlert');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 5000); // 5 seconds
</script>