<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lintas Anugerah Cargo</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('skydash') }}/vendors/feather/feather.css">
    <link rel="stylesheet" href="{{ asset('skydash') }}/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="{{ asset('skydash') }}/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('skydash') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="{{ asset('skydash') }}/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="/text/css" href="{{ asset('skydash') }}js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('skydash') }}/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('Image') }}/favicon.ico" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
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
    <script src="{{ asset('skydash') }}/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('skydash') }}/vendors/chart.js/Chart.min.js"></script>
    <script src="{{ asset('skydash') }}/vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="{{ asset('skydash') }}/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <script src="{{ asset('skydash') }}/js/dataTables.select.min.js"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('skydash') }}/js/off-canvas.js"></script>
    <script src="{{ asset('skydash') }}/js/hoverable-collapse.js"></script>
    <script src="{{ asset('skydash') }}/js/template.js"></script>
    <script src="{{ asset('skydash') }}/js/settings.js"></script>
    <script src="{{ asset('skydash') }}/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('skydash') }}/js/dashboard.js"></script>
    <script src="{{ asset('skydash') }}/js/Chart.roundedBarCharts.js"></script>
    <!-- Open Street Maps-->
    <script>
        var map = L.map('mapid').setView([-6.200000, 106.816666], 13); // Koordinat Jakarta, bisa disesuaikan

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
