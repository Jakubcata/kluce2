<!doctype html>
<html lang="en">
  <head>
    <title>Kľúče</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.0/themes/base/jquery-ui.css">

    <link rel="stylesheet" href="/styles/jakubcata.css">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="/static/fa/css/all.min.css">

    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/jquery-ui.min.js"></script>
    <script src="/static/js/popper.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="/static/js/datepicker-sk.js"></script>
    <script src="/main.js"></script>

  </head>

  <body>
    <nav class="navbar sticky-top navbar-expand-sm navbar-light jk-color-background mb-3">
      <a class="navbar-brand" href="https://www.jakubcata.eu">Jakubčatá</a>
      <button class="navbar-toggler border-0 order-2 order-sm-1" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse order-3 order-sm-2" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="https://docs.google.com/spreadsheets/d/1eyqSX9-FAIXc5gtrN2kmQ2CQeGQ-trfrPV7Cm0qd1cA/edit?fbclid=IwAR1KCWZHzSz5cLH98VDjVXkK5SAeugBezMmT9UiXaacDRJqrBX7gn_rMOU0#gid=1994379597">Podzemné priestory</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" target="_blank" href="https://docs.google.com/spreadsheets/d/1eH5YqEM_BFtvCm4PZvEjS5bPgR_skHv_c65X23VXbyE/edit?fbclid=IwAR3GRFhi9K3zAcmowYPh0zAHkRcVui7F3DnKKQFaFvz2Pz0hwPU5J0PYbdM#gid=1393635604">Farské priestory</a>
          </li>
        </ul>
        <div class="ml-md-5">
          <button id="btnInstall" type="button" class="btn btn-info btn-sm d-none">
            <i class="fas fa-download"></i>
            <span class="">
              Nainštalovať aplikáciu
            </span>
          </button>
        </div>
      </div>
      <div class="ml-auto order-1 order-sm-2">
        <div>
  <button type="button" class="btn btn-secondary"  data-toggle="modal" data-target="#addUserModal">
    <i class="fas fa-user-plus"></i>
    <span class="d-none d-sm-inline">
      Pridať držiteľa
    </span>
  </button>
</div>
      </div>
    </nav>

    <div class="container-fluid">

  <div class="row" id="cardRow">
  </div> <!--main row-->

  <!-- keycard template -->
  <div id="keyTemplate" class="col-sm-6 col-md-4 col-xl-3 mb-3 default-hidden">
    <div class="card border-0 very-card">
      <div class="card-header text-center key-name">
        Modré kľúče
      </div>
      <div class="card-body p-1">
        <ul class="list-group list-group-flush">
          <!-- multicell with owner info -->
          <li class="list-group-item pr-0 pt-0 pb-0">
            <div class="row">
              <div class="col-2 align-self-center">
                <i class="fas fa-user"></i>
              </div>
              <div class="col-10 pl-0">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-2 align-self-center">
                        <i class="fab fa-facebook-messenger"></i>
                      </div>
                      <div class="col-10">
                        <a class="key-owner" target="_blank" rel="noopener noreferrer">
                          ---
                        </a>
                      </div>
                    </div>
                  </li>
                  <li class="list-group-item">
                    <div class="row">
                      <div class="col-2 align-self-center">
                        <i class="fas fa-phone"></i>
                      </div>
                      <div class="col-10">
                        <a class="key-phone" target="_blank" rel="noopener noreferrer">
                          ---
                        </a>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </li>

          <li class="list-group-item">
            <div class="row">
              <div class="col-2 align-self-center">
                <i class="fas fa-clock" data-toggle="tooltip" title="Do kedy sú kľúče obsadené"></i>
              </div>
              <div class="col-10 key-date">
                ---
              </div>
            </div>
          </li>
          <li class="list-group-item">
            <div class="row">
              <div class="col-2 align-self-center">
                <i class="fas fa-comment"></i>
              </div>
              <div class="col-10 key-comment">
                ---
              </div>
            </div>
          </li>

        </ul>
      </div>
      <div class="card-footer text-muted">
        <select class="custom-select transparent-background border-0" id="inputGroupSelect01">
          <option selected disabled>Zmeniť držiteľa</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Modal new user -->
  <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pridať potenciálneho držiteľa</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-row mb-3">
              <div class="col">
                <input type="text" class="form-control" id="inputFirstName" placeholder="Meno">
              </div>
              <div class="col">
                <input type="text" class="form-control" id="inputSurname" placeholder="Priezvisko">
              </div>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-phone"><i class="fas fa-phone"></i></span>
              </div>
              <input type="text" class="form-control" id="inputPhone" placeholder="+421 905 778 898" aria-describedby="addon-phone">
            </div>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="addon-facebook"><i class="fab fa-facebook-square"></i></span>
              </div>
              <input type="text" class="form-control" id="inputFacebookLink" placeholder="https://www.facebook.com/jozko.fekete" aria-describedby="addon-facebook">
              <div class="invalid-feedback">
                Prosím zadaj vo formáte: https://www.facebook.com/mojprofil
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <div id="alertInvalidHolderInfo" class="alert alert-danger default-hidden p-1 mb-0 mr-auto" role="alert">
            Vyplň správne všetky údaje.
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušiť</button>
          <button type="button" class="btn btn-primary" id="btnSaveUser">Uložiť</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal change holder -->
  <div class="modal fade" id="changeHolderModal" tabindex="-1" role="dialog" aria-labelledby="changeHolderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changeHolderLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="mb-0">
            <div class="form-group row">
              <label for="inputDate" class="col col-form-label">Do kedy kľúče potrebuješ</label>
              <div class="col align-self-center">
                <input type="text" class="form-control" id="inputDate" onkeypress="return false;">
              </div>
            </div>
            <div class="form-group">
              <textarea class="form-control" rows="2" id="inputReason" placeholder="Tu môžeš napísať načo ti kľúče treba."></textarea>
            </div>
            <hr/>
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="switchNotNeeded">
              <label class="custom-control-label" for="switchNotNeeded">Kľúče mám ale nepotrebujem</label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Zrušiť</button>
          <button type="button" class="btn btn-primary" id="btnSaveHolder">Uložiť</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal change holder -->
  <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="changeHolderLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Držiteľ úspešne pridaný
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Od teraz sa môžeš nájsť v ponuke.
        </div>
      </div>
    </div>
  </div>

    </div>

  </body>
</html>
