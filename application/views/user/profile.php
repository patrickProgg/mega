<!-- <section class="h-100 gradient-custom-2"> -->
<section id="content">
  <div class="container py-5 h-100">
    <!-- <div class="row d-flex justify-content-center"> -->
    <div class="row d-flex justify-content-end">
      <!-- <div class="col col-lg-9 col-xl-8"> -->
      <div class="col-md-8">
        <div class="card">
          <div class="rounded-top text-white" style="background-color: #000; height: 350px; position: relative;">
            <!-- Cover Photo -->
            <!-- <img src="<?= $admin->image ? $admin->image : 'users.jpg' ?>" alt="Cover Photo" -->
            <img src="<?= base_url('assets/image/dota.jpg'); ?>" alt="Cover Photo"
              style="width: 100%; height: 100%; object-fit: cover;">
            <!-- Profile Picture -->
            <div class="position-absolute d-flex align-items-center" style="bottom: -50px; left: 20px;">
              <img src="<?= $admin->image ? $admin->image : base_url('assets/image/users.png'); ?>"
                alt="Profile Picture"
                class="img-thumbnail rounded-circle"
                style="width: 150px; height: 150px; object-fit: cover; border: 1px solid white;">
              <div class="ms-3">
                <h5 class="mb-0" style="font-weight: bold; font-size: 1.25em; text-align: center;"><?= $admin->username ?></h5>
                <div class="position-absolute" style="bottom: 70px; left: 670px; text-align: center;">
                  <a href="#" class="btn btn-primary d-flex align-items-center justify-content-center"
                    style="height:30px; width:135px; background-color: rgba(255, 255, 255, 0.5); border:1px solid black; color: black;"
                    data-bs-toggle="modal"
                    data-bs-target="#editProfileModal">
                    <img src="<?= base_url('assets/image/edit3.png'); ?>" alt="Edit Icon" style="width: 18px; height: 18px; margin-right: 8px;">
                    Edit Profile
                  </a>
                </div>

              </div>
            </div>

            <!-- Profile Info -->
            <div class="ms-3" style="margin-top: 80px; padding-left: 140px;">
              <h5><?= $admin->username ?></h5>
              <p><?= $admin->address ?></p>
            </div>
          </div>
          <div class="p-4 text-black bg-body-tertiary">
            <div class="d-flex justify-content-end text-center py-1 text-body">
              <div>
                <p class="mb-1 h5">253</p>
                <p class="small text-muted mb-0">Photos
                </p>
              </div>
              <div class="px-3">
                <p class="mb-1 h5">1026</p>
                <p class="small text-muted mb-0">Followers</p>
              </div>
              <div>
                <p class="mb-1 h5">478</p>
                <p class="small text-muted mb-0">Following</p>
              </div>
            </div>
          </div>
          <div class="card-body p-4 text-black">
            <div class="mb-5 text-body">
              <div class="d-flex justify-content-between align-items-center">
                <p class="lead fw-normal mb-1">About</p>
                <a href="#" class="btn btn-primary mb-2 d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-target="#uploadModal"
                  style="height:30px; width:160px; background-color: rgba(135, 206, 235, 0.5); border:1px solid #3C91E6; color: black; border-radius: 170px; ">
                  <i class='bx bxs-cloud-upload'></i>
                  <span class="text">Upload Photos</span>
                </a>

              </div>
              <div class="p-4 bg-body-tertiary">
                <p class="font-italic mb-0">
                  <img src="<?= base_url('assets/image/user.png'); ?>" alt="Location Image" style="max-width: 20px; margin-right: 5px;">
                  <span>:</span>
                  <span><?= $admin->username; ?></span>
                </p>
                <p class="font-italic mb-0">
                  <img src="<?= base_url('assets/image/email.png'); ?>" alt="Location Image" style="max-width: 18px; margin-right: 6px; margin-left: 1px;">
                  <span>:</span>
                  <span><?= $admin->email; ?></span>
                </p>
                <p class="font-italic mb-0">
                  <img src="<?= base_url('assets/image/loc.png'); ?>" alt="Location Image" style="max-width: 20px; margin-right: 5px;">
                  <span>:</span>
                  <span><?= $admin->address; ?></span>
                </p>
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4 text-body">
              <p class="lead fw-normal mb-0">Recent Photos</p>
              <!-- <p class="mb-0"><a href="#!" class="text-muted">Show all</a></p> -->
            </div>
            <div class="row g-2">
              <?php if ($admin !== null) : ?>
                <?php if (!empty($admin->photos)) : ?>
                  <?php $total_photos = count($admin->photos); ?>
                  <?php for ($i = max($total_photos - 4, 0); $i < $total_photos; $i++) : ?>
                    <div class="col-md-6 mb-2">
                      <img src="<?= isset($admin->photos[$i]->photo_data) ? $admin->photos[$i]->photo_data : 'N/A' ?>" alt="Image <?= $admin->photos[$i]->photo_id ?>" class="w-100 rounded-3" style="width: 10px; height: 300px; object-fit: contain; border: 1px solid grey;">
                    </div>
                  <?php endfor; ?>
                <?php else : ?>
                  <p>No photos available.</p>
                <?php endif; ?>
              <?php else : ?>
                <p>Admin not found or no data available.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-4">

        <div class="d-flex justify-content-between align-items-center mb-4 text-body">
          <p class="lead fw-normal mb-0">Recent Photos</p>
        </div>
        <div class="row g-2">
          <?php if ($admin !== null) : ?>
            <?php if (!empty($admin->photos)) : ?>
              <?php $total_photos = count($admin->photos); ?>
              <?php for ($i = max(5, 0); $i < $total_photos; $i++) : ?>
                <div class="col-md-6 mb-2">
                  <img src="<?= isset($admin->photos[$i]->photo_data) ? $admin->photos[$i]->photo_data : 'N/A' ?>" alt="Image <?= $admin->photos[$i]->photo_id ?>" class="w-100 rounded-3" style="width: 50px; height: 200px; object-fit: contain; border: 1px solid grey;">
                </div>
              <?php endfor; ?>
            <?php else : ?>
              <p>No photos available.</p>
            <?php endif; ?>
          <?php else : ?>
            <p>Admin not found or no data available.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <!-- </div> -->

    <!-- edit profile modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
      <div class="modal-dialog" style="max-width: 500px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="<?= base_url('Dashboard_controller/edit/' . $admin->id); ?>" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="<?= $admin->username; ?>" oninput="capitalizeFirstLetter(this)">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?= $admin->email; ?>" oninput="capitalizeFirstLetter(this)">
              </div>
              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" class="form-control" id="address" value="<?= $admin->address; ?>" oninput="capitalizeFirstLetter(this)">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" name="password" class="form-control" id="password" value="<?= $admin->password; ?>" oninput="capitalizeFirstLetter(this)">
              </div>

              <div class="mb-3 d-flex align-items-center">
                <img src="<?= $admin->image ? $admin->image : base_url('assets/image/users.png'); ?>"
                  alt="Profile Image"
                  id="profilePreviews"
                  style="max-width: 150px; max-height: 150px;">
                <img src="<?= base_url('assets/image/camera.png'); ?>"
                  alt="Edit Icon"
                  style="width: 30px; height: 30px; margin-left: 10px; cursor: pointer;"
                  onclick="document.getElementById('profileInputs').click();">

                <input type="file" id="profileInputs" name="image" style="display: none;" onchange="previewProfile(event);">
              </div>

              <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>[]

    <!-- upload modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadModalLabel">Upload Photos</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="<?= base_url('Dashboard_controller/addPhoto') ?>" method="POST" enctype="multipart/form-data">
              <div class="mb-4 d-flex justify-content-center">
                <img id="selectedImage" src="<?= base_url('assets/image/users.png'); ?>" alt="example placeholder" style="width: 200px;" onclick="document.getElementById('photoInput').click();" />
                <input type="file" class="form-control d-none" id="photoInput" name="photo_data" onchange="displaySelectedImage(event, 'selectedImage')" required />
              </div>
              <div class="d-flex justify-content-center mt-2">
                <button type="submit" class="btn btn-upload btn-success">Upload</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

</section>
<?php if ($this->session->flashdata('updated')) { ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Updated',
      text: 'Successfully Updated',
      timer: 1000, // The alert will automatically close after 3 seconds
      showConfirmButton: false // Hides the "OK" button
    });
  </script>
<?php } ?>

<?php if ($this->session->flashdata('success')) { ?>
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Added',
      text: 'Successfully Added',
      timer: 1000, // The alert will automatically close after 3 seconds
      showConfirmButton: false // Hides the "OK" button
    });
  </script>
<?php } ?>