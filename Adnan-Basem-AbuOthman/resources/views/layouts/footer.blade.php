 <!-- Footer -->
 <footer id="contact">
     <div class="container">
         <div class="row g-5">
             <div class="col-md-4">
                 <h4 class="footer-heading">Sakan</h4>
                 <p class="text-muted mb-4">Your trusted platform for finding the perfect student accommodation.
                     Safe, reliable, and tailored for you.</p>
                 <div class="d-flex gap-3">
                     <a href="#" class="text-primary"><i class="bi bi-facebook fs-5"></i></a>
                     <a href="#" class="text-primary"><i class="bi bi-twitter fs-5"></i></a>
                     <a href="#" class="text-primary"><i class="bi bi-instagram fs-5"></i></a>
                 </div>
             </div>
             <div class="col-md-4">
                 <h5 class="footer-heading">Quick Links</h5>
                 <ul class="footer-links">
                     <li><a href="{{ route('index') }}">Home</a></li>
                     <li><a href="{{ route('universitiesPage') }}">Universities</a></li>
                     <li><a href="{{ route('apartmentspage') }}">Apartments</a></li>

                     @if(!Auth::check())

                         <li><a href="{{ route('login') }}">Login</a></li>

                     @endauth


                 </ul>
             </div>
             <div class="col-md-4">
                 <h5 class="footer-heading">Contact Us</h5>

                 <div class="mt-4 text-muted small">
                     <p class="mb-1"><i class="bi bi-envelope me-2"></i> support@sakan.app</p>
                     <p><i class="bi bi-telephone me-2"></i>+962 780632320</p>
                 </div>
             </div>
         </div>
         <div class="text-center mt-5 pt-4 border-top">
             <p class="text-muted text-sm">&copy; {{ date('Y') }} Sakan. All rights reserved.</p>
         </div>
     </div>
 </footer>
