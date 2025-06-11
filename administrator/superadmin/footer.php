 <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  Infinity Group Solutions. All rights reserved
                </div>

              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
   <!-- Translator code here --> 
   <script src="https://translate.google.com/translate_a/element.js?cb=loadGoogleTranslate"></script>
    <script>
        function loadGoogleTranslate() {
            new google.translate.TranslateElement({pageLanguage: 'en', includedLanguages: 'en,fr'}, 'google_translate_element');
        }

        function changeLanguage(language) {
            var googleTranslateElement = document.querySelector('.goog-te-combo');
            if (googleTranslateElement) {
                googleTranslateElement.value = language;
                googleTranslateElement.dispatchEvent(new Event('change'));
            }
        }
    </script>
   <!-- Translator code here -->

    <!-- Main JS -->
    <script src="../assets/js/main.js"></script>
    
    <script src="../js/jquery.dataTables.js"></script>

    <!-- Page JS -->
    <script src="../assets/js/dashboards-analytics.js"></script>
  </body>
</html>
