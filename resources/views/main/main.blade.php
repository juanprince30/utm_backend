
@include('main.sidebar')
@extends('main.index')

@section('content')
    <div>
      <!-- container -->
      <div class="custom-container">
        <!-- row -->
        <div class="row mb-6 g-6">
          <div class="col-xl-8 col-lg-6">
            <div class="bg-gradient-mixed p-8 py-10 rounded-3 p-lg-7">
              <!--heading-->
              <h1 class="fs-3">👋 Hello Ana,</h1>
              <p class="mb-0">Welcome to your E-commerce Dashboard! Monitor your sales,</p>
              <p>track your progress, and gain valuable insights.</p>
              <a href="#!" class="btn btn-dark">Start AI</a>
            </div>
          </div>
          <div class="col-xl-4 col-lg-6">
            <!-- card -->
            <div class="card card-lg">
              <!-- card body -->
              <div class="card-body">
                <div class="mb-4 position-relative py-2">
                  <div>
                    <h5 class="mb-1">Ideas for You</h5>
                  </div>
                  <!-- swiper navigation-->
                  <div class="swiper-navigation position-absolute top-50 end-10 me-4 me-lg-8 me-xl-4">
                    <div class="swiper-button-prev ms-n3"></div>
                    <div class="swiper-button-next ms-6"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <!-- swiper -->
                    <div class="swiper-container swiper" id="swiper-1" data-pagination-type="" data-speed="900"
                      data-space-between="100" data-pagination="false" data-navigation="true" data-autoplay="false"
                      data-autoplay-delay="2000"
                      data-breakpoints='{"480": {"slidesPerView": 1}, "768": {"slidesPerView": 1}, "1024": {"slidesPerView": 1}, "1200": {"slidesPerView": 1}}'>
                      <div class="swiper-wrapper">
                        <div class="swiper-slide">
                          <div>
                            <h4>Create a Blog Post for your product</h4>

                            <div>
                              <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem</p>
                            </div>
                            <div class="mt-4">
                              <a href="#!" class="btn btn-white btn-sm">Read Now</a>
                            </div>
                          </div>
                        </div>
                        <!-- Add more slides as needed -->
                      </div>
                      <!-- Add Pagination -->
                      <div class="swiper-pagination"></div>
                      <!-- Add Navigation -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- row -->
        <div class="row row-cols-1 row-cols-xl-3 row-cols-md-3 mb-6 g-6">
          <div class="col">
            <!-- card -->
            <div class="card card-lg">
              <!-- card body -->
              <div class="card-body d-flex flex-column gap-8">
                <div class="d-flex align-items-center gap-3">
                  <div class="icon-shape icon-lg rounded-circle bg-warning-darker text-warning-lighter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                      class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                      <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                      <path d="M17 17h-11v-14h-2" />
                      <path d="M6 5l14 1l-1 7h-13" />
                    </svg>
                  </div>
                  <div>Orders</div>
                </div>
                <div class="d-flex justify-content-between align-items-center lh-1">
                  <div class="fs-3 fw-bold">5,312</div>
                  <div class="text-success small">
                    <span>2.29%</span>
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 17l6 -6l4 4l8 -8" />
                        <path d="M14 7l7 0l0 7" />
                      </svg>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <!-- card -->
            <div class="card card-lg">
              <!-- card body -->
              <div class="card-body d-flex flex-column gap-8">
                <div class="d-flex align-items-center gap-3">
                  <div class="icon-shape icon-lg rounded-circle bg-success-darker text-success-lighter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                      class="icon icon-tabler icons-tabler-outline icon-tabler-coin">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                      <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                      <path d="M12 7v10" />
                    </svg>
                  </div>
                  <div>Revenue</div>
                </div>
                <div class="d-flex justify-content-between align-items-center lh-1">
                  <div class="fs-3 fw-bold">$120,000</div>
                  <div class="text-warning small">
                    <span>2.19%</span>
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-trending-up">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 17l6 -6l4 4l8 -8" />
                        <path d="M14 7l7 0l0 7" />
                      </svg>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <!-- card -->
            <div class="card card-lg">
              <!-- card body -->
              <div class="card-body d-flex flex-column gap-8">
                <div class="d-flex align-items-center gap-3">
                  <div class="icon-shape icon-lg rounded-circle bg-info-darker text-info-lighter">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                      stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                      class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                      <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                      <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                    </svg>
                  </div>
                  <div>Conversion Rate</div>
                </div>
                <div class="d-flex justify-content-between align-items-center lh-1">
                  <div class="fs-3 fw-bold">3.5%</div>
                  <div class="text-danger small">
                    <span>3.19%</span>
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                        class="icon icon-tabler icons-tabler-outline icon-tabler-trending-down">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 7l6 6l4 -4l8 8" />
                        <path d="M21 10l0 7l-7 0" />
                      </svg>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- row -->
        <div class="row g-6 mb-6">
          <div class="col-xl-8 col-12">
            <!-- card -->
            <div class="card card-lg">
              <!--  card body -->
              <div class="card-body d-flex flex-column gap-5">
                <div class="mb-4">
                  <!-- heading -->
                  <h5 class="mb-0">Revenue</h5>
                </div>
                <div class="bg-gray-100 p-3 rounded-3">
                  <ul class="nav nav-pills-white nav-fill" id="chartTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link active" id="current-week-tab" data-bs-toggle="pill"
                        data-bs-target="#current-week" type="button" role="tab" aria-controls="current-week"
                        aria-selected="true">
                        <span class="d-flex flex-column">
                          <span class="d-flex align-items-center gap-2">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-circle text-primary">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                  d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" />
                              </svg></span><span>Total Income</span>
                          </span>
                          <span class="text-start fs-3 fw-semibold mt-2">$120,000</span>
                        </span>
                      </button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link" id="past-week-tab" data-bs-toggle="pill" data-bs-target="#past-week"
                        type="button" role="tab" aria-controls="past-week" aria-selected="false">
                        <span class="d-flex flex-column">
                          <span class="d-flex align-items-center gap-2">
                            <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                fill="currentColor"
                                class="icon icon-tabler icons-tabler-filled icon-tabler-circle text-warning">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                  d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" />
                              </svg></span><span>Total expenses</span>
                          </span>
                          <span class="text-start fs-3 fw-semibold mt-2">$198,214</span>
                        </span>
                      </button>
                    </li>
                  </ul>
                </div>

                <div class="tab-content" id="chartTabsContent">
                  <div class="tab-pane fade show active" id="current-week" role="tabpanel"
                    aria-labelledby="current-week-tab">
                    <div id="totalIncomeChart"></div>
                  </div>
                  <div class="tab-pane fade" id="past-week" role="tabpanel" aria-labelledby="past-week-tab">
                    <div id="totalExpensesChart"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-4 col-12">
            <!-- card -->
            <div class="card card-lg">
              <!-- card body -->
              <div class="card-body">
                <!-- heading -->
                <h5 class="mb-6">Product Sales</h5>
                <div id="totalSale" class="d-flex justify-content-center"></div>
                <!-- table -->
                <table class="table table-sm table-borderless mb-0 mt-5">
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-circle text-primary">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" />
                            </svg>
                          </span>
                          <span class="ms-1">Smartphones</span>
                        </div>
                      </td>
                      <td class="d-flex justify-content-end gap-2">
                        <span> $22,120 </span>
                        <span class="text-secondary">38.1%</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-circle text-warning">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" />
                            </svg>
                          </span>
                          <span class="ms-1">Laptops</span>
                        </div>
                      </td>
                      <td class="d-flex justify-content-end gap-2">
                        <span> $4510 </span>
                        <span class="text-secondary">28.6%</span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-circle text-info">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" />
                            </svg>
                          </span>
                          <span class="ms-1">Headphones</span>
                        </div>
                      </td>
                      <td class="d-flex justify-content-end gap-2">
                        <span> $800 </span>
                        <span class="text-secondary"> 23.8% </span>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-circle text-danger">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" />
                            </svg>
                          </span>
                          <span class="ms-1">Cameras</span>
                        </div>
                      </td>
                      <td class="d-flex justify-content-end gap-2">
                        <span> $420 </span>
                        <span class="text-secondary"> 9.5% </span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- row -->
        <div class="row g-6 mb-6">
          <div class="col-xl-8">
            <!-- card -->
            <div class="card card-lg">
              <!-- card header -->
              <div class="card-header border-bottom-0">
                <div>
                  <h5 class="mb-0">Orders</h5>
                </div>
              </div>
              <!-- table -->
              <div class="table-responsive">
                <table class="table text-nowrap mb-0 table-centered table-hover">
                  <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Amount</th>
                      <th>Shipping Method</th>
                      <th>Delivery Date</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>#DU005</td>
                      <td>$150</td>
                      <td>Standard</td>
                      <td>Jan 20, 2025</td>
                      <td><span class="badge text-info-emphasis bg-info-subtle">Shipped</span></td>
                      <td><a href="#!" class="btn btn-white btn-sm">View</a></td>
                    </tr>
                    <tr>
                      <td>#DU004</td>
                      <td>$200</td>
                      <td>Express</td>
                      <td>Jan 22, 2025</td>
                      <td><span class="badge text-warning-emphasis bg-warning-subtle">Pending</span></td>
                      <td><a href="#!" class="btn btn-white btn-sm">View</a></td>
                    </tr>
                    <tr>
                      <td>#DU003</td>
                      <td>$300</td>
                      <td>Overnight</td>
                      <td>Jan 18, 2025</td>
                      <td><span class="badge text-danger-emphasis bg-danger-subtle">Cancel</span></td>
                      <td><a href="#!" class="btn btn-white btn-sm">View</a></td>
                    </tr>
                    <tr>
                      <td>#DU002</td>
                      <td>$560</td>
                      <td>Overnight</td>
                      <td>Jan 13, 2025</td>
                      <td><span class="badge text-success-emphasis bg-success-subtle">Completed</span></td>
                      <td><a href="#!" class="btn btn-white btn-sm">View</a></td>
                    </tr>
                    <tr>
                      <td>#DU002</td>
                      <td>$560</td>
                      <td>Overnight</td>
                      <td>Jan 11, 2025</td>
                      <td><span class="badge text-success-emphasis bg-success-subtle">Completed</span></td>
                      <td><a href="#!" class="btn btn-white btn-sm">View</a></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-xl-4">
            <!-- card -->
            <div class="card card-lg">
              <!--  card body -->
              <div class="card-body">
                <!-- heading -->
                <h5 class="mb-6">Revenue by Location</h5>
                <div id="map-world" style="width: 100%; height: 250px"></div>
                <div class="d-flex flex-column gap-2">
                  <div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span>United States</span>
                      <span>$22,120</span>
                    </div>
                    <div class="progress mt-1" style="height: 6px">
                      <div class="progress-bar" role="progressbar" aria-label="Example 1px high" style="width: 45%"
                        aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span>India</span>
                      <span>$12,756</span>
                    </div>
                    <div class="progress mt-1" style="height: 6px">
                      <div class="progress-bar bg-success" role="progressbar" aria-label="Example 1px high"
                        style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span>United Kingdom</span>
                      <span>$8,864</span>
                    </div>
                    <div class="progress mt-1" style="height: 6px">
                      <div class="progress-bar bg-info" role="progressbar" aria-label="Example 1px high"
                        style="width: 38%" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div>
                    <div class="d-flex justify-content-between align-items-center">
                      <span>Sweden</span>
                      <span>$6,124</span>
                    </div>
                    <div class="progress mt-1" style="height: 6px">
                      <div class="progress-bar bg-warning" role="progressbar" aria-label="Example 1px high"
                        style="width: 18%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row g-6 mb-6">
          <div class="col-xl-4">
            <!-- card -->
            <div class="card card-lg">
              <!-- card body -->
              <div class="card-body">
                <!-- heading -->
                <div class="mb-5">
                  <h5>Sales by gender</h5>
                </div>
                <div id="salesBygender"></div>
              </div>
              <div class="border-top border-dashed px-6 py-4">
                <div class="d-flex align-items-center justify-content-center gap-6">
                  <div class="d-flex align-items-center gap-1">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                        fill="currentColor"
                        class="icon icon-tabler icons-tabler-filled icon-tabler-circle text-primary">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" />
                      </svg></span><span class="lh-1">Mens</span>
                  </div>
                  <div class="d-flex align-items-center gap-1">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                        fill="currentColor"
                        class="icon icon-tabler icons-tabler-filled icon-tabler-circle text-warning">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" />
                      </svg></span><span class="lh-1">Womens</span>
                  </div>
                  <div class="d-flex align-items-center gap-1">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-circle text-danger">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 3.34a10 10 0 1 1 -4.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 4.995 -8.336z" />
                      </svg></span><span class="lh-1">Kids</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-8">
            <!-- card -->
            <div class="card card-lg">
              <div class="card-header border-bottom-0">
                <!-- heading -->
                <div>
                  <h5 class="mb-0">Top Selling Products</h5>
                </div>
              </div>
              <!-- table -->
              <div class="table-responsive">
                <table class="table text-nowrap mb-0 table-centered table-hover">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Sale</th>
                      <th>Revenue</th>
                      <th>Rating</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div>
                          <a href="#!" class="d-flex align-items-center gap-2 text-inherit">
                            <img src="assets/images/ecommerce/product-1.jpg" alt="product" class="rounded" width="40" />
                            <span class="text-truncate">Transparent Sunglasses</span>
                          </a>
                        </div>
                      </td>
                      <td>454</td>
                      <td>$50,000</td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-star text-warning">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" />
                            </svg>
                          </span>
                          <span>5/5</span>
                        </div>
                      </td>
                      <td><span class="badge text-info-emphasis bg-info-subtle">In Stock</span></td>
                    </tr>
                    <tr>
                      <td>
                        <div>
                          <a href="#!" class="d-flex align-items-center gap-2 text-inherit">
                            <img src="assets/images/ecommerce/product-2.jpg" alt="product" class="rounded" width="40" />
                            <span class="text-truncate">Frames Still Life Glasses</span>
                          </a>
                        </div>
                      </td>
                      <td>454</td>
                      <td>$50,000</td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-star text-warning">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" />
                            </svg>
                          </span>
                          <span>5/5</span>
                        </div>
                      </td>
                      <td><span class="badge text-info-emphasis bg-info-subtle">In Stock</span></td>
                    </tr>
                    <tr>
                      <td>
                        <div>
                          <a href="#!" class="d-flex align-items-center gap-2 text-inherit">
                            <img src="assets/images/ecommerce/product-3.jpg" alt="product" class="rounded" width="40" />
                            <span>Slightly Rounded Frame</span>
                          </a>
                        </div>
                      </td>
                      <td>124</td>
                      <td>$30,000</td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-star-half text-warning">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M12 1a.993 .993 0 0 1 .823 .443l.067 .116l2.852 5.781l6.38 .925c.741 .108 1.08 .94 .703 1.526l-.07 .095l-.078 .086l-4.624 4.499l1.09 6.355a1.001 1.001 0 0 1 -1.249 1.135l-.101 -.035l-.101 -.046l-5.693 -3l-5.706 3c-.105 .055 -.212 .09 -.32 .106l-.106 .01a1.003 1.003 0 0 1 -1.038 -1.06l.013 -.11l1.09 -6.355l-4.623 -4.5a1.001 1.001 0 0 1 .328 -1.647l.113 -.036l.114 -.023l6.379 -.925l2.853 -5.78a.968 .968 0 0 1 .904 -.56zm0 3.274v12.476a1 1 0 0 1 .239 .029l.115 .036l.112 .05l4.363 2.299l-.836 -4.873a1 1 0 0 1 .136 -.696l.07 -.099l.082 -.09l3.546 -3.453l-4.891 -.708a1 1 0 0 1 -.62 -.344l-.073 -.097l-.06 -.106l-2.183 -4.424z" />
                            </svg>
                          </span>
                          <span>4.0/5</span>
                        </div>
                      </td>
                      <td><span class="badge text-warning-emphasis bg-warning-subtle">Low Stock</span></td>
                    </tr>
                    <tr>
                      <td>
                        <div>
                          <a href="#!" class="d-flex align-items-center gap-2 text-inherit">
                            <img src="assets/images/ecommerce/product-4.jpg" alt="product" class="rounded" width="40" />
                            <span>Colored-Transparent Sunglasses</span>
                          </a>
                        </div>
                      </td>
                      <td>124</td>
                      <td>$30,000</td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-star-half text-warning">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M12 1a.993 .993 0 0 1 .823 .443l.067 .116l2.852 5.781l6.38 .925c.741 .108 1.08 .94 .703 1.526l-.07 .095l-.078 .086l-4.624 4.499l1.09 6.355a1.001 1.001 0 0 1 -1.249 1.135l-.101 -.035l-.101 -.046l-5.693 -3l-5.706 3c-.105 .055 -.212 .09 -.32 .106l-.106 .01a1.003 1.003 0 0 1 -1.038 -1.06l.013 -.11l1.09 -6.355l-4.623 -4.5a1.001 1.001 0 0 1 .328 -1.647l.113 -.036l.114 -.023l6.379 -.925l2.853 -5.78a.968 .968 0 0 1 .904 -.56zm0 3.274v12.476a1 1 0 0 1 .239 .029l.115 .036l.112 .05l4.363 2.299l-.836 -4.873a1 1 0 0 1 .136 -.696l.07 -.099l.082 -.09l3.546 -3.453l-4.891 -.708a1 1 0 0 1 -.62 -.344l-.073 -.097l-.06 -.106l-2.183 -4.424z" />
                            </svg>
                          </span>
                          <span>4.0/5</span>
                        </div>
                      </td>
                      <td><span class="badge text-warning-emphasis bg-warning-subtle">Low Stock</span></td>
                    </tr>
                    <tr>
                      <td>
                        <div>
                          <a href="#!" class="d-flex align-items-center gap-2 text-inherit">
                            <img src="assets/images/ecommerce/product-5.jpg" alt="product" class="rounded" width="40" />
                            <span>Sun Glasses Table</span>
                          </a>
                        </div>
                      </td>
                      <td>124</td>
                      <td>$30,000</td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-star-half text-warning">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M12 1a.993 .993 0 0 1 .823 .443l.067 .116l2.852 5.781l6.38 .925c.741 .108 1.08 .94 .703 1.526l-.07 .095l-.078 .086l-4.624 4.499l1.09 6.355a1.001 1.001 0 0 1 -1.249 1.135l-.101 -.035l-.101 -.046l-5.693 -3l-5.706 3c-.105 .055 -.212 .09 -.32 .106l-.106 .01a1.003 1.003 0 0 1 -1.038 -1.06l.013 -.11l1.09 -6.355l-4.623 -4.5a1.001 1.001 0 0 1 .328 -1.647l.113 -.036l.114 -.023l6.379 -.925l2.853 -5.78a.968 .968 0 0 1 .904 -.56zm0 3.274v12.476a1 1 0 0 1 .239 .029l.115 .036l.112 .05l4.363 2.299l-.836 -4.873a1 1 0 0 1 .136 -.696l.07 -.099l.082 -.09l3.546 -3.453l-4.891 -.708a1 1 0 0 1 -.62 -.344l-.073 -.097l-.06 -.106l-2.183 -4.424z" />
                            </svg>
                          </span>
                          <span>4.0/5</span>
                        </div>
                      </td>
                      <td><span class="badge text-warning-emphasis bg-warning-subtle">Low Stock</span></td>
                    </tr>
                    <tr>
                      <td>
                        <div>
                          <a href="#!" class="d-flex align-items-center gap-2 text-inherit">
                            <img src="assets/images/ecommerce/product-6.jpg" alt="product" class="rounded" width="40" />
                            <span>Rounded Frames Glasses</span>
                          </a>
                        </div>
                      </td>
                      <td>124</td>
                      <td>$30,000</td>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                              fill="currentColor"
                              class="icon icon-tabler icons-tabler-filled icon-tabler-star-half text-warning">
                              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                              <path
                                d="M12 1a.993 .993 0 0 1 .823 .443l.067 .116l2.852 5.781l6.38 .925c.741 .108 1.08 .94 .703 1.526l-.07 .095l-.078 .086l-4.624 4.499l1.09 6.355a1.001 1.001 0 0 1 -1.249 1.135l-.101 -.035l-.101 -.046l-5.693 -3l-5.706 3c-.105 .055 -.212 .09 -.32 .106l-.106 .01a1.003 1.003 0 0 1 -1.038 -1.06l.013 -.11l1.09 -6.355l-4.623 -4.5a1.001 1.001 0 0 1 .328 -1.647l.113 -.036l.114 -.023l6.379 -.925l2.853 -5.78a.968 .968 0 0 1 .904 -.56zm0 3.274v12.476a1 1 0 0 1 .239 .029l.115 .036l.112 .05l4.363 2.299l-.836 -4.873a1 1 0 0 1 .136 -.696l.07 -.099l.082 -.09l3.546 -3.453l-4.891 -.708a1 1 0 0 1 -.62 -.344l-.073 -.097l-.06 -.106l-2.183 -4.424z" />
                            </svg>
                          </span>
                          <span>4.8/5</span>
                        </div>
                      </td>
                      <td><span class="badge text-danger-emphasis bg-danger-subtle">Out of Stock</span></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="offcanvasNav offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
  aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">

    <a class="d-flex align-items-center gap-2" href="">
      <h1 class="fw-bold fs-4  site-logo-text">ArtisanFaso</h1>
    </a>

    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body p-0">
    <ul class="navbar-nav flex-column  ">
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href="{{ asset('admin/dasher-1.0.0/src/index.html') }}"><span class="nav-icon"><svg xmlns="http://www.w3.org/2000/svg"
              width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
              stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-files">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M15 3v4a1 1 0 0 0 1 1h4" />
              <path d="M18 17h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h4l5 5v7a2 2 0 0 1 -2 2z" />
              <path d="M16 17v2a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2h2" />
            </svg> <span class="text">Project</span></a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href="">
          <span class="nav-icon "><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
              fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-chart-histogram">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M3 3v18h18" />
              <path d="M20 18v3" />
              <path d="M16 16v5" />
              <path d="M12 13v8" />
              <path d="M8 16v5" />
              <path d="M3 11c6 0 5 -5 9 -5s3 5 9 5" />
            </svg></span> <span class="text">Analytics</span></a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href=""><span class="nav-icon"><svg
              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-bag">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path
                d="M6.331 8h11.339a2 2 0 0 1 1.977 2.304l-1.255 8.152a3 3 0 0 1 -2.966 2.544h-6.852a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304z" />
              <path d="M9 11v-5a3 3 0 0 1 6 0v5" />
            </svg></span> <span class="text">Ecommerce</span></a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href=""><span class="nav-icon"><svg
              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-phone">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path
                d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
            </svg></span> <span class="text">CRM</span></a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href=""><span class="nav-icon"><svg
              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-brand-mastercard">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
              <path d="M12 9.765a3 3 0 1 0 0 4.47" />
              <path d="M3 5m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
            </svg></span> <span class="text">Finance</span></a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href=""><span class="nav-icon"><svg
              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-news">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path
                d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11" />
              <path d="M8 8l4 0" />
              <path d="M8 12l4 0" />
              <path d="M8 16l4 0" />
            </svg></span> <span class="text">Blog</span></a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href=""><span class="nav-icon"><svg
              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
              <path d="M9 9l1 0" />
              <path d="M9 13l6 0" />
              <path d="M9 17l6 0" />
            </svg></span> <span class="text">File</span></a>
      </li>

      <!-- Nav item -->
      <li class="nav-item">
        <div class="nav-heading">Apps</div>
        <hr class="mx-5 nav-line mb-1" />
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href="">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-calendar">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" />
              <path d="M16 3v4" />
              <path d="M8 3v4" />
              <path d="M4 11h16" />
              <path d="M11 15h1" />
              <path d="M12 15v3" />
            </svg>
          </span>
          <span class="text">Calendar</span>
        </a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href="">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-message-dots">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M12 11v.01" />
              <path d="M8 11v.01" />
              <path d="M16 11v.01" />
              <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3z" />
            </svg>
          </span>
          <span class="text">Chat</span>
        </a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href="">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-brand-trello">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
              <path d="M7 7h3v10h-3z" />
              <path d="M14 7h3v6h-3z" />
            </svg>
          </span>
          <span class="text">Kanban</span>
        </a>

      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#e-mail" role="button" data-bs-toggle="dropdown"
          aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
              <path d="M3 7l9 6l9 -6" />
            </svg>
          </span>
          <span class="text">Email</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="">Inbox</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Email Detail</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Compose</a>
          </li>
        </ul>
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-bag-edit">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path
                d="M11 21h-2.426a3 3 0 0 1 -2.965 -2.544l-1.255 -8.152a2 2 0 0 1 1.977 -2.304h11.339a2 2 0 0 1 1.977 2.304l-.109 .707" />
              <path d="M9 11v-5a3 3 0 0 1 6 0v5" />
              <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
            </svg>
          </span>
          <span class="text">Ecommerce</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Product Detail</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Add Product</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="">Shopping cart</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Checkout</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Customer</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Seller</a>
          </li>
        </ul>
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-shopping-cart">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
              <path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
              <path d="M17 17h-11v-14h-2" />
              <path d="M6 5l14 1l-1 7h-13" />
            </svg>
          </span>
          <span class="text">Order</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="">List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Details</a>
          </li>

        </ul>
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-file-analytics">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
              <path d="M9 17l0 -5" />
              <path d="M12 17l0 -1" />
              <path d="M15 17l0 -3" />
            </svg>
          </span>
          <span class="text">Project</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="">Grid</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">List</a>
          </li>
          <li class="dropdown-submenu">
            <a class="nav-link dropdown-toggle" href="#!" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">Single</a>
            <ul class="dropdown-menu">
              <li class="nav-item">
                <a class="nav-link" href="">Overview</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="">Task</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="">Budget</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="">Files</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="">Team</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Create Project</a>
          </li>
        </ul>
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-chart-pie-2">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M12 3v9h9" />
              <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
            </svg>
          </span>
          <span class="text">CRM</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="">Contacts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Company</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Deals</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Deals Single</a>
          </li>
        </ul>
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-invoice">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
              <path
                d="M19 12v7a1.78 1.78 0 0 1 -3.1 1.4a1.65 1.65 0 0 0 -2.6 0a1.65 1.65 0 0 1 -2.6 0a1.65 1.65 0 0 0 -2.6 0a1.78 1.78 0 0 1 -3.1 -1.4v-14a2 2 0 0 1 2 -2h7l5 5v4.25" />
            </svg>
          </span>
          <span class="text">Invoice</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="">List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Detail</a>
          </li>

        </ul>
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-user">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
              <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
            </svg>
          </span>
          <span class="text">Profile</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="">Overview</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Project</a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="">Team</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Followers</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Activity</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Settings</a>
          </li>
        </ul>
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-article">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
              <path d="M7 8h10" />
              <path d="M7 12h10" />
              <path d="M7 16h10" />
            </svg>
          </span>
          <span class="text">Blog</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="">List</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Details</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="">Create</a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <div class="nav-heading">Pages</div>
        <hr class="mx-5 nav-line mb-1" />
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-file">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
            </svg>
          </span>
          <span class="text">Pages</span>
        </a>
        <ul class="dropdown-menu flex-column">



          <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/dasher-1.0.0/src/pages/error/maintenance.html') }}">Maintenance</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/dasher-1.0.0/src/pages/error/404-error.html') }}">404 Error</a>
          </li>
        </ul>
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" />
              <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
              <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
            </svg>
          </span>
          <span class="text">Authentication</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/dasher-1.0.0/src/pages/authentication/sign-in.html') }}">Sign In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/dasher-1.0.0/src/pages/authentication/sign-up.html') }}">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/dasher-1.0.0/src/pages/authentication/forget-password.html') }}">Forget Password</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/dasher-1.0.0/src/pages/authentication/reset-password.html') }}">Reset Password</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ asset('admin/dasher-1.0.0/src/pages/authentication/otp-varification.html') }}">Otp Varification </a>
          </li>
        </ul>
      </li>


      <li class="nav-item">
        <div class="nav-heading">Components</div>
        <hr class="mx-5 nav-line mb-1" />
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-chart-infographic">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M7 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
              <path d="M7 3v4h4" />
              <path d="M9 17l0 4" />
              <path d="M17 14l0 7" />
              <path d="M13 13l0 8" />
              <path d="M21 12l0 9" />
            </svg>
          </span>
          <span class="text">Apexcharts</span>
        </a>
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link" href="" role="button">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-box">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
              <path d="M12 12l8 -4.5" />
              <path d="M12 12l0 9" />
              <path d="M12 12l-8 -4.5" />
            </svg>
          </span>
          <span class="text">Components</span>
        </a>
      </li>


      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href="">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-file-code">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
              <path d="M10 13l-1 2l1 2" />
              <path d="M14 13l1 2l-1 2" />
            </svg>
          </span>
          <span class="text">Docs</span>
        </a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link" href="=">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-git-merge">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M7 18m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
              <path d="M7 6m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
              <path d="M17 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
              <path d="M7 8l0 8" />
              <path d="M7 8a4 4 0 0 0 4 4h4" />
            </svg>
          </span>
          <span class="text">Changelog</span>
        </a>
      </li>
      <li class="nav-item">
        <div class="nav-heading">Misc</div>
        <hr class="mx-5 nav-line mb-1" />
      </li>
      <!-- Nav item -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-menu-deep">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M4 6h16" />
              <path d="M7 12h13" />
              <path d="M10 18h10" />
            </svg>
          </span>
          <span class="text">Menu Level</span>
        </a>
        <ul class="dropdown-menu flex-column">
          <li class="nav-item">
            <a class="nav-link" href="#!">Level 1a</a>
          </li>

          <li class="dropdown-submenu">
            <a class="nav-link dropdown-toggle" href="#!" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">Level 1b</a>
            <ul class="dropdown-menu">
              <li class="nav-item">
                <a class="nav-link" href="#!">Level 2a</a>
              </li>
              <li class="dropdown-submenu">
                <a class="nav-link dropdown-toggle" href="#!" role="button" data-bs-toggle="dropdown"
                  aria-expanded="false">Level 2b</a>
                <ul class="dropdown-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="#!">Level 3a</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#!">Level 3b</a>
                  </li>
                </ul>
              </li>

            </ul>
          </li>

        </ul>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link disabled text-gray-400" href="#!" aria-disabled="true" style="cursor:not-allowed">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-circle-off">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M20.042 16.045a9 9 0 0 0 -12.087 -12.087m-2.318 1.677a9 9 0 1 0 12.725 12.73" />
              <path d="M3 3l18 18" />
            </svg>
          </span>
          <span class="text">Disabled</span>
        </a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link position-relative " href="#!">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-tag">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
              <path
                d="M3 6v5.172a2 2 0 0 0 .586 1.414l7.71 7.71a2.41 2.41 0 0 0 3.408 0l5.592 -5.592a2.41 2.41 0 0 0 0 -3.408l-7.71 -7.71a2 2 0 0 0 -1.414 -.586h-5.172a3 3 0 0 0 -3 3z" />
            </svg>
          </span>
          <span class="text">Label
            <span class="badge bg-info-subtle text-info-emphasis position-absolute end-0 me-2">New</span></span>
        </a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link position-relative " href="#!"
          aria-label="External Link">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-external-link">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" />
              <path d="M11 13l9 -9" />
              <path d="M15 4h5v5" />
            </svg>
          </span>
          <span class="text">External Link </span>

        </a>
      </li>
      <!-- Nav item -->
      <li class="nav-item">
        <a class="nav-link position-relative " href="{{ asset('admin/dasher-1.0.0/src/pages/blank.html') }}"
          aria-label="External Link">
          <span class="nav-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
              class="icon icon-tabler icons-tabler-outline icon-tabler-file">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M14 3v4a1 1 0 0 0 1 1h4" />
              <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
            </svg>
          </span>
          <span class="text">Blank </span>

        </a>
      </li>
      <!-- Nav item -->
      <li>
        <div class="text-center py-5 upgrade-ui ">
          <div>
            <img src="{{ asset('admin/dasher-1.0.0/src/assets/images/avatar/avatar-1.jpg') }}" alt="" class="avatar avatar-md rounded-circle">
            <div class="my-3">
              <h5 class="mb-1 fs-6">Jitu Chauhan</h5>
              <span class="text-secondary">Free Version - 1 Month</span>
            </div>
            <a href="#!" class="btn btn-primary">Upgrade</a>

          </div>

        </div>
      </li>

    </ul>
  </div>
</div>

    <!-- Main Content -->
  <div id="content" class="position-relative h-100">

@endsection

@include('main.navbarWithsidebar')