<!-- <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'> -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/all.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/boxicons.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css" rel="stylesheet" />


<script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>

<script src="<?php echo base_url(); ?>assets/js/sweetalert2@11.js"></script>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MEGA</title>
	<link rel="icon" type="image/png" href="<?= base_url('assets/image/MEGA2.png'); ?>">
</head>

</html>

<style>
	/* @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap'); */
	@import url('<?php echo base_url(); ?>assets/css/style.css');

	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	a {
		text-decoration: none;
	}

	li {
		list-style: none;
	}

	:root {
		--poppins: 'Poppins', sans-serif;
		--lato: 'Lato', sans-serif;

		--light: #F9F9F9;
		--blue: #3C91E6;
		--light-blue: #CFE8FF;
		--grey: #eee;
		--dark-grey: #AAAAAA;
		--dark: #342E37;
		--red: #DB504A;
		--yellow: #FFCE26;
		--light-yellow: #FFF2C6;
		--orange: #FD7238;
		--light-orange: #FFE0D3;
	}

	html {
		overflow-x: hidden;
	}

	body.dark {
		--light: #0C0C1E;
		--grey: #060714;
		--dark: #FBFBFB;
	}

	body {
		background: var(--grey);
		overflow-x: hidden;
	}



	/* SIDEBAR */


	/* #sidebar {
		transition: width 0.3s ease, opacity 0.3s ease;
	} */



	#sidebar {
		position: fixed;
		top: 0;
		left: 0;
		width: 220px;
		height: 100%;
		background: var(--light);
		z-index: 2000;
		font-family: var(--lato);
		transition: .5s ease-in-out;
		/* transition: width 0.3s ease; */
		overflow-x: hidden;
		scrollbar-width: none;
		/* visibility: hidden; */
		/* Hide until JS applies the correct class */
	}

	#sidebar::--webkit-scrollbar {
		display: none;
	}

	#sidebar.hide {
		width: 70px;
	}

	#sidebar .brand {
		font-size: 24px;
		font-weight: 700;
		height: 56px;
		display: flex;
		align-items: center;
		color: var(--blue);
		position: sticky;
		top: 0;
		left: 0;
		background: var(--light);
		z-index: 500;
		padding-bottom: 20px;
		box-sizing: content-box;
		padding-left: 18px;
	}

	#sidebar .brand .bx {
		min-width: 60px;
		display: flex;
		justify-content: center;

	}

	#sidebar .side-menu {
		width: 100%;
		margin-top: 48px;
		padding-left: 20px;
		/* Move content to the left */
	}

	#sidebar .side-menu li {
		height: 48px;
		background: transparent;
		/* margin-left: 6px; */
		border-radius: 48px 0 0 48px;
		padding: 4px;
	}

	#sidebar .side-menu li.active {
		background: var(--grey);
		position: relative;
	}

	#sidebar .side-menu li.active::before {
		content: '';
		position: absolute;
		width: 40px;
		height: 40px;
		border-radius: 50%;
		top: -40px;
		right: 0;
		box-shadow: 20px 20px 0 var(--grey);
		z-index: -1;
	}

	#sidebar .side-menu li.active::after {
		content: '';
		position: absolute;
		width: 40px;
		height: 40px;
		border-radius: 50%;
		bottom: -40px;
		right: 0;
		box-shadow: 20px -20px 0 var(--grey);
		z-index: -1;
	}

	#sidebar .side-menu li a {
		width: 100%;
		height: 100%;
		background: var(--light);
		display: flex;
		align-items: center;
		border-radius: 48px;
		font-size: 16px;
		color: var(--dark);
		white-space: nowrap;
		overflow-x: hidden;
	}

	#sidebar .side-menu.top li.active a {
		color: var(--blue);
	}

	/* #sidebar.hide .side-menu li a {
		width: calc(48px - (4px * 2));
		transition: width .3s ease;
	} */

	#sidebar.hide .side-menu li a .text {
		display: none !important;
		/* transition: width .3s ease; */
	}

	#sidebar.hide .brand .text {
		display: none !important;
	}


	#sidebar.hide .side-menu li a {
		justify-content: left;
		padding: 0;
	}


	#sidebar .side-menu li a.logout {
		color: var(--red);
	}

	#sidebar .side-menu.top li a:hover {
		color: var(--blue);
	}

	#sidebar .side-menu li a .bx {
		min-width: calc(60px - ((4px + 6px) * 2));
		display: flex;
		justify-content: center;
	}

	/* #sidebar.hide .side-menu li a .bx {
		min-width: 60px;
		justify-content: flex-start;
		margin-left: 15px;
	} */


	/* SIDEBAR */





	/* CONTENT */
	#content {
		position: relative;
		width: calc(100% - 220px);
		left: 220px;
		transition: .5s ease-in-out;
	}

	#sidebar.hide~#content {
		width: calc(100% - 70px);
		left: 70px;
	}

	/* .modal-content{
		background-color: transparent;
		border: none;
	} */




	/* NAVBAR */

	#content nav {
		height: 56px;
		background: var(--light);
		padding: 0 24px;
		display: flex;
		align-items: center;
		grid-gap: 24px;
		font-family: var(--lato);
		position: sticky;
		top: 0;
		left: 0;
		z-index: 1000;
	}

	#content nav::before {
		content: '';
		position: absolute;
		width: 40px;
		height: 40px;
		bottom: -40px;
		left: 0;
		border-radius: 50%;
		box-shadow: -20px -20px 0 var(--light);
	}

	#content nav a {
		color: var(--dark);
	}

	#content nav .bx.bx-menu {
		cursor: pointer;
		color: var(--dark);
	}

	#content nav .nav-link {
		font-size: 16px;
		transition: .3s ease;
	}

	#content nav .nav-link:hover {
		color: var(--blue);
	}

	#content nav form {
		max-width: 400px;
		width: 100%;
		margin-right: auto;
	}

	#content nav form .form-input {
		display: flex;
		align-items: center;
		height: 36px;
	}

	#content nav form .form-input input {
		flex-grow: 1;
		padding: 0 16px;
		height: 100%;
		border: none;
		background: var(--grey);
		border-radius: 36px 0 0 36px;
		outline: none;
		width: 100%;
		color: var(--dark);
	}

	#content nav form .form-input button {
		width: 36px;
		height: 100%;
		display: flex;
		justify-content: center;
		align-items: center;
		background: var(--blue);
		color: var(--light);
		font-size: 18px;
		border: none;
		outline: none;
		border-radius: 0 36px 36px 0;
		cursor: pointer;
	}

	.btn {
		font-size: 14px;
	}

	#content nav .notification {
		font-size: 20px;
		position: relative;
	}

	#content nav .notification .num {
		position: absolute;
		top: -6px;
		right: -6px;
		width: 20px;
		height: 20px;
		border-radius: 50%;
		border: 2px solid var(--light);
		background: var(--red);
		color: var(--light);
		font-weight: 700;
		font-size: 12px;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	#content nav .profile img {
		width: 36px;
		height: 36px;
		object-fit: cover;
		border-radius: 50%;
	}

	#content nav .switch-mode {
		display: block;
		min-width: 50px;
		height: 25px;
		border-radius: 25px;
		background: var(--grey);
		cursor: pointer;
		position: relative;
	}

	#content nav .switch-mode::before {
		content: '';
		position: absolute;
		top: 2px;
		left: 2px;
		bottom: 2px;
		width: calc(25px - 4px);
		background: var(--blue);
		border-radius: 50%;
		transition: all .3s ease;
	}

	#content nav #switch-mode:checked+.switch-mode::before {
		left: calc(100% - (25px - 4px) - 2px);
	}

	/* NAVBAR */




	/* MAIN */

	/* ::-webkit-scrollbar {
		width: 0px;
		background: transparent;
	} */

	#content main {
		width: 100%;
		padding: 8px 15px;
		font-family: var(--poppins);
		max-height: calc(100vh - 56px);
		overflow-y: auto;
	}

	#content main .head-title {
		display: flex;
		align-items: center;
		justify-content: space-between;
		grid-gap: 16px;
		flex-wrap: wrap;
	}

	.head-title .buttons {
		display: flex;
		flex-direction: column;
		/* Stack buttons vertically */
		gap: 10px;
		/* Add spacing between buttons */
	}


	#content main .head-title .left h1 {
		font-size: 36px;
		font-weight: 600;
		margin-bottom: 10px;
		color: var(--dark);
	}

	#content main .head-title .left .breadcrumb {
		display: flex;
		align-items: center;
		grid-gap: 16px;
	}

	#content main .head-title .left .breadcrumb li {
		color: var(--dark);
	}

	#content main .head-title .left .breadcrumb li a {
		color: var(--dark-grey);
		pointer-events: auto;
		/* ✅ Enables clicking on all tabs */
		cursor: pointer;
		/* Shows hand cursor on hover */
	}


	#content main .head-title .left .breadcrumb li a.active {
		color: var(--blue);
		pointer-events: unset;
	}

	#content main .head-title .btn-upload {
		height: 36px;
		padding: 0 16px;
		border-radius: 36px;
		background: var(--red);
		color: var(--light);
		display: flex;
		justify-content: center;
		align-items: center;
		grid-gap: 10px;
		font-weight: 500;
	}

	#content main .head-title .btn-download {
		height: 36px;
		padding: 0 16px;
		border-radius: 36px;
		background: var(--blue);
		color: var(--light);
		display: flex;
		justify-content: center;
		align-items: center;
		grid-gap: 10px;
		font-weight: 500;
	}


	#content main .box-info {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
		grid-gap: 24px;
		margin-top: 36px;
	}

	#content main .box-info li {
		padding: 24px;
		background: var(--light);
		border-radius: 20px;
		display: flex;
		align-items: center;
		grid-gap: 24px;
		/* font-size: 18px; */
		/* background-color: transparent; */
	}

	#content main .box-info li .bx {
		width: 80px;
		height: 80px;
		border-radius: 10px;
		font-size: 36px;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	#content main .box-info li:nth-child(1) .bx {
		background: var(--light-blue);
		/* background: transparent; */
		color: var(--blue);
		/* color: var(--black); */
		/* background-image: url('<?= base_url('assets/image/2.png'); ?>');
		background-size: cover;
		background-position: center; */
	}

	#content main .box-info li:nth-child(3) .bx {
		background: var(--light-yellow);
		/* background: transparent; */
		color: var(--yellow);
		/* color: var(--black); */
		/* background-image: url('<?= base_url('assets/image/1.png'); ?>');
		background-size: cover;
		background-position: center; */
	}

	#content main .box-info li:nth-child(2) .bx {
		background: rgb(198, 158, 226);
		/* background: transparent; */
		color: rgb(101, 20, 114);
		/* color: var(--black); */
		/* background-image: url('<?= base_url('assets/image/3.png'); ?>');
		background-size: cover;
		background-position: center; */
	}

	#content main .box-info li:nth-child(4) .bx {
		background: #D4EDDA;
		/* background: transparent; */
		color: rgb(67, 160, 88);
		/* color: var(--black); */
		/* background-image: url('<?= base_url('assets/image/4.png'); ?>');
		background-size: cover;
		background-position: center; */
	}

	#content main .box-info li .text h3 {
		font-size: 20px;
		font-weight: 600;
		color: var(--dark);
		/* color: var(--black); */
	}

	#content main .box-info li .text p {
		color: var(--dark);
		/* color: var(--black); */
	}

	#content main .table-data {
		display: flex;
		flex-wrap: wrap;
		grid-gap: 24px;
		/* margin-top: 24px; */
		margin-top: 10px;
		width: 100%;
		color: var(--dark);
		/* color: #ffffff; */
		font-size: 14px;
	}

	#content main .table-data>div {
		border-radius: 20px;
		background: var(--light);
		padding: 24px;
		overflow-x: auto;
		/* background-color: rgba(255, 255, 255, 0.5	);  */
		/* White background with 50% opacity */
	}

	#content main .table-data .head {
		display: flex;
		align-items: center;
		grid-gap: 16px;
		margin-bottom: 24px;
	}

	#content main .table-data .head h3 {
		margin-right: auto;
		font-size: 24px;
		font-weight: 600;
	}

	#content main .table-data .head .bx {
		cursor: pointer;
	}

	#content main .table-data .order {
		flex-grow: 1;
		flex-basis: 500px;
	}

	#content main .table-data .order table {
		width: 100%;
		border-collapse: collapse;
	}

	#content main .table-data .order table th {
		padding-bottom: 12px;
		font-size: 13px;
		text-align: left;
		padding-left: 0px;
		border-bottom: 1px solid var(--grey);
	}

	#content main .table-data .order table td {
		padding: 12px 0;
		font-size: 14px;
		;
	}

	#content main .table-data .order table tr td:first-child {
		/* display: flex; */
		/* align-items: center; */
		/* grid-gap: 12px; */
		padding-left: 10px;
	}


	#content main .table-data .order table tbody tr:hover {
		/* background: var(--grey); */
		background: var(--light-blue);
		/* background: rgba(7, 210, 224, 0.3); */
	}


	#content main .table-data .todo {
		flex-grow: 1;
		flex-basis: 500px;
	}

	#content main .table-data .todo .todo-list {
		width: 100%;
	}


	#content main .table-data .todo .todo-list li .bx {
		cursor: pointer;
	}



	.account-settings .user-profile {
		margin: 0 0 1rem 0;
		padding-bottom: 1rem;
		text-align: center;
	}

	.account-settings .user-profile .user-avatar {
		margin: 0 0 1rem 0;
	}

	.account-settings .user-profile .user-avatar img {
		width: 90px;
		height: 90px;
		-webkit-border-radius: 100px;
		-moz-border-radius: 100px;
		border-radius: 100px;
	}

	.account-settings .user-profile h5.user-name {
		margin: 0 0 0.5rem 0;
	}

	.account-settings .user-profile h6.user-email {
		margin: 0;
		font-size: 0.8rem;
		font-weight: 400;
		color: #9fa8b9;
	}

	.account-settings .about {
		margin: 2rem 0 0 0;
		text-align: center;
	}

	.account-settings .about h5 {
		margin: 0 0 15px 0;
		color: #007ae1;
	}

	.account-settings .about p {
		font-size: 0.825rem;
	}

	.form-control {
		border: 1px solid #cfd1d8;
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		border-radius: 2px;
		font-size: .825rem;
		background: #ffffff;
		color: #2e323c;
	}

	.card {
		background: #ffffff;
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		border: 0;
		margin-bottom: 1rem;
	}

	.tab-content {
		visibility: hidden;
		position: absolute;
		width: 100%;
	}

	.tab-content.active {
		visibility: visible;
		position: relative;
	}

	/* MAIN */
	/* CONTENT */









	@media screen and (max-width: 768px) {
		#sidebar {
			width: 200px;
		}

		#content {
			width: calc(100% - 60px);
			left: 200px;
		}

		#content nav .nav-link {
			display: none;
		}
	}






	@media screen and (max-width: 576px) {
		#content nav form .form-input input {
			display: none;
		}

		#content nav form .form-input button {
			width: auto;
			height: auto;
			background: transparent;
			border-radius: none;
			color: var(--dark);
		}

		#content nav form.show .form-input input {
			display: block;
			width: 100%;
		}

		#content nav form.show .form-input button {
			width: 36px;
			height: 100%;
			border-radius: 0 36px 36px 0;
			color: var(--light);
			background: var(--red);
		}

		#content nav form.show~.notification,
		#content nav form.show~.profile {
			display: none;
		}

		#content main .box-info {
			grid-template-columns: 1fr;
		}

		#content main .table-data .head {
			min-width: 420px;
		}

		#content main .table-data .order table {
			min-width: 420px;
		}

		#content main .table-data .todo .todo-list {
			min-width: 420px;
		}

	}
</style>