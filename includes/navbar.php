<nav class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top px-4">

    <div class="container-fluid">

        <h4 class="text-white mb-0 fw-bold">
            Student Analytics System
        </h4>

        <div class="ms-auto d-flex align-items-center">

            <span class="text-white me-3">
                Welcome,
                <?php echo $_SESSION['fullname']; ?>
            </span>

            <a href="logout.php" class="btn btn-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>

        </div>

    </div>

</nav>