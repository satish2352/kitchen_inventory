@include('layouts.header')
@include('layouts.sidebar')

@yield('content')
<div class="main">
      <div class="inner-top container-fluid p-3">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center">
          <a href="{{ route('/dashboard') }}">
            <button class="btn btn-light">
              <i class="bi bi-arrow-90deg-left"></i>
            </button>
          </a>
          <h5 class="sub-title">Submit Shopping list</h5>

          <button class="btn btn-light">
            <i class="bi bi-check2"></i>
          </button>
        </div>
      </div>
      <div class="filter">
        <div class="shopping-list-row d-flex align-items-center p-3">
          <!-- Search Input -->
          <div class="input-group search-input">
            <input
              type="text"
              class="form-control"
              placeholder="Search..."
              aria-label="Search"
            />
            <button class="btn btn-srh">
              <i class="bi bi-search"></i>
            </button>
          </div>

          <!-- Location Icon -->
          <!-- <button class="btn btn-white mx-2">
            <i class="bi bi-geo-alt-fill"></i>
          </button> -->

          <!-- Bar Grid Icon -->
          <!-- <button class="btn btn-white btn-delete">
            <i class="bi bi-filter"></i>
          </button> -->
        </div>
        <div class="container-fluid px-3">
          <a href="#">
            <button type="button" class="btn btn-outline-danger fs-6">
              Show last submitted shopping list
            </button>
          </a>
          <!-- Border Box -->
          <div class="border-box">
            <!-- Header Title -->
            <div class="grid-header text-center">
              <h6 class="m-0 text-white">Chicken/Proteins</h6>
            </div>

            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-striped">
                <!-- Table Head -->
                <thead class="table-header">
                  <tr>
                    <th>Item</th>
                    <th>M-K</th>
                    <th>S.Q</th>
                    <th>Unit</th>
                    <th>1X</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <!-- Table Body -->
                <tbody>
                  <tr>
                    <td>Wings</td>
                    <td>5</td>
                    <td>10</td>
                    <td>kg</td>
                    <td>3</td>
                    <td>15</td>
                  </tr>
                  <tr>
                    <td>Eggs</td>
                    <td>12</td>
                    <td>24</td>
                    <td>dozen</td>
                    <td>1</td>
                    <td>24</td>
                  </tr>
                  <tr>
                    <td>Wings</td>
                    <td>5</td>
                    <td>10</td>
                    <td>kg</td>
                    <td>3</td>
                    <td>15</td>
                  </tr>
                  <tr>
                    <td>Eggs</td>
                    <td>12</td>
                    <td>24</td>
                    <td>dozen</td>
                    <td>1</td>
                    <td>24</td>
                  </tr>
                  <tr>
                    <td>Eggs</td>
                    <td>12</td>
                    <td>24</td>
                    <td>dozen</td>
                    <td>1</td>
                    <td>24</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Border Box -->
          <div class="border-box">
            <!-- Header Title -->
            <div class="grid-header text-center">
              <h6 class="m-0 text-white">Chicken/Proteins</h6>
            </div>

            <!-- Table -->
            <div class="table-responsive">
              <table class="table table-striped">
                <!-- Table Head -->
                <thead class="table-header">
                  <tr>
                    <th>Item</th>
                    <th>M-K</th>
                    <th>S.Q</th>
                    <th>Unit</th>
                    <th>1X</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <!-- Table Body -->
                <tbody>
                  <tr>
                    <td>Wings</td>
                    <td>5</td>
                    <td>10</td>
                    <td>kg</td>
                    <td>3</td>
                    <td>15</td>
                  </tr>
                  <tr>
                    <td>Eggs</td>
                    <td>12</td>
                    <td>24</td>
                    <td>dozen</td>
                    <td>1</td>
                    <td>24</td>
                  </tr>
                  <tr>
                    <td>Wings</td>
                    <td>5</td>
                    <td>10</td>
                    <td>kg</td>
                    <td>3</td>
                    <td>15</td>
                  </tr>
                  <tr>
                    <td>Eggs</td>
                    <td>12</td>
                    <td>24</td>
                    <td>dozen</td>
                    <td>1</td>
                    <td>24</td>
                  </tr>
                  <tr>
                    <td>Eggs</td>
                    <td>12</td>
                    <td>24</td>
                    <td>dozen</td>
                    <td>1</td>
                    <td>24</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- Delete Confirmation Popup -->
      <div id="confirmPopup" class="confirm-popup-container">
        <div class="confirm-popup-content">
          <h4 class="confirm-popup-title">Please Confirm</h4>
          <p class="confirm-popup-text">
            Are you sure to create new <br />
            shopping list?
          </p>
          <div class="d-flex justify-content-around mt-4 confrm">
            <button id="cancelDelete" class="btn br">NO</button>
            <button id="confirmDelete" class="btn">YES</button>
          </div>
        </div>
      </div>
    </div>
 @extends('layouts.footer')