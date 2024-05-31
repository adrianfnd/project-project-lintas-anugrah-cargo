{{-- FOOTER --}}
<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
      <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2021.  Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
      <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i></span>
    </div>
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
      <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Distributed by <a href="https://www.themewagon.com/" target="_blank">Themewagon</a></span> 
    </div>
  </footer> 
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
<!-- End custom js for this page-->