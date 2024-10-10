<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bookstore</title>

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <!-- Bootstrap Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
  </head>

  <body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <!-- logo -->
        <div class="row d-flex justify-content-end">
          <nav class="navbar navbar-expand-lg">
            <div class="container">
              <a class='navbar-brand' href='/'>
                Bookstore
              </a>
            </div>
          </nav>
        </div>

        <!-- navbar -->
        <div class="row d-flex justify-content-start">
          <nav class="navbar navbar-expand-lg">
            <div class="container">
            </a>
            <button
              class="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarNav"
              aria-controls="navbarNav"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav mx-auto">
                
                <?php if ( isset( $_SESSION['user'] ) ) : ?>
                <li class="nav-item">
                  <a aria-current='page' class='nav-link' href='/'>Home</a>
                </li>
                <li class="nav-item">
                    <a aria-current='page' class='nav-link' href='/logout'>Logout</a>
                  </li>
                  <?php else : ?>
                      <li class="nav-item">
                  <a aria-current='page' class='nav-link' href='/login'>Login</a>
                </li>
                <li class="nav-item">
                  <a aria-current='page' class='nav-link' href='/signup'>Sign Up</a>
                </li>
                    <?php endif; ?>
              </ul>
            </div>
            </div>
          </nav>
        </div>
      </div>
    </nav>