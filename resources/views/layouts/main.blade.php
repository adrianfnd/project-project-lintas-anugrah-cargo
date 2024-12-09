<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lintas Anugerah Cargo</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/feather/feather.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="/text/css" href="{{ asset('assets') }}js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('Image') }}/favicon.ico" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        .info-wrapper {
            padding: 20px;
            background: white;
            border-top: 1px solid #eee;
        }

        .info-header {
            display: flex;
            align-items: center;
            background: #4b49ac;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }

        .info-icon {
            margin-right: 10px;
        }

        .info-content {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .profile {
            display: flex;
            align-items: center;
        }

        .profile-pic {
            border-radius: 50%;
            margin-right: 10px;
        }

        .profile-details {
            display: flex;
            flex-direction: column;
        }

        .delivery-details {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include ('layouts.navbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include ('layouts.sidebar')
            <!-- partial -->
            <div class="main-panel">
                @yield('content')
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include ('layouts.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="{{ asset('assets') }}/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets') }}/vendors/chart.js/Chart.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="{{ asset('assets') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="{{ asset('assets') }}/js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('assets') }}/js/off-canvas.js"></script>
    <script src="{{ asset('assets') }}/js/hoverable-collapse.js"></script>
    <script src="{{ asset('assets') }}/js/template.js"></script>
    <script src="{{ asset('assets') }}/js/settings.js"></script>
    <script src="{{ asset('assets') }}/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('assets') }}/js/dashboard.js"></script>
    <script src="{{ asset('assets') }}/js/Chart.roundedBarCharts.js"></script>
    <!-- Open Street Maps-->
    <script>
        var map = L.map('mapid').setView([-6.200000, 106.816666], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Marker pada peta
        var marker = L.marker([-6.200000, 106.816666]).addTo(map)
            .bindPopup('Lokasi Anda')
            .openPopup();
    </script>
    {{-- Bintang Operator --}}
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            function convertRateToStars(rate) {
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= rate) {
                        stars += '<span class="star">★</span>';
                    } else {
                        stars += '<span class="star">☆</span>';
                    }
                }
                return stars;
            }

            document.querySelectorAll('.rate').forEach((element) => {
                const rateValue = parseFloat(element.getAttribute('data-rate'));
                const stars = convertRateToStars(rateValue);
                element.innerHTML = stars;
            });
        });
    </script>
    <!-- End custom js for this page-->
    </div>
    </div>
    </div>
</body>

</html>
