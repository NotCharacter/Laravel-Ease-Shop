  <!-- Footer -->
  <footer class="bg-gray-900 text-white pt-12 pb-8">
      <div class="max-w-7xl mx-auto px-4">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
              <div>
                  <h3 class="text-xl font-bold mb-4">ShopEase</h3>
                  <p class="text-gray-400">Your premium shopping destination for the latest trends and quality products.</p>
              </div>
              <div>
                  <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                  <ul class="space-y-2">
                      <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
                      <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
                      <li><a href="#" class="text-gray-400 hover:text-white">FAQs</a></li>
                      <li><a href="#" class="text-gray-400 hover:text-white">Shipping Info</a></li>
                  </ul>
              </div>
              <div>
                  <h4 class="text-lg font-semibold mb-4">Customer Service</h4>
                  <ul class="space-y-2">
                      <li><a href="#" class="text-gray-400 hover:text-white">Track Order</a></li>
                      <li><a href="#" class="text-gray-400 hover:text-white">Returns</a></li>
                      <li><a href="#" class="text-gray-400 hover:text-white">Size Guide</a></li>
                      <li><a href="#" class="text-gray-400 hover:text-white">Gift Cards</a></li>
                  </ul>
              </div>
              <div>
                  <h4 class="text-lg font-semibold mb-4">Connect With Us</h4>
                  <div class="flex space-x-4">
                      <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                      <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                      <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                      <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-pinterest"></i></a>
                  </div>
              </div>
          </div>
          <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
              <p>&copy; 2025 ShopEase. All rights reserved.</p>
          </div>
      </div>
  </footer>

  <script>
      // Categories Script
      let currentIndex = 0;
      const track = document.getElementById("categoriesTrack");
      const itemWidth = 25;
      const totalItems = track.children.length;
      const maxIndex = Math.max(0, totalItems - 4);

      function slideCategories(direction) {
          if (direction === "next" && currentIndex < maxIndex) {
              currentIndex++;
          } else if (direction === "prev" && currentIndex > 0) {
              currentIndex--;
          }
          track.style.transform = `translateX(-${currentIndex * itemWidth}%)`;
          updateNavigationButtons();
      }


      // Like Script
      function updateNavigationButtons() {
          const prevButton = track.parentElement.previousElementSibling;
          const nextButton = track.parentElement.nextElementSibling;
          prevButton.style.display = currentIndex === 0 ? "none" : "block";
          nextButton.style.display = currentIndex >= maxIndex ? "none" : "block";
      }

      updateNavigationButtons();
      document.querySelectorAll(".like-btn").forEach((button) => {
          button.addEventListener("click", function() {
              let productId = this.getAttribute("data-id");

              fetch("{{ route('likes.add') }}", {
                      method: "POST",
                      headers: {
                          "Content-Type": "application/json",
                          "X-CSRF-TOKEN": "{{ csrf_token() }}",
                      },
                      body: JSON.stringify({
                          id: productId
                      }),
                  })
                  .then((response) => response.json())
                  .then((data) => {
                      if (data.success) {
                          alert("Product added to likes!");
                          updateLikesCount();
                      }
                  });
          });
      });

      function updateLikesCount() {
          fetch("{{ route('likes.count') }}")
              .then((response) => response.json())
              .then((data) => {
                  document.getElementById("likes-count").innerText = data.count;
              });
      }

      //   Like Remove
      function removeFromLikes(id) {
          fetch("{{ route('likes.remove') }}", {
              method: "POST",
              headers: {
                  "Content-Type": "application/json",
                  "X-CSRF-TOKEN": "{{ csrf_token() }}"
              },
              body: JSON.stringify({
                  id
              })
          }).then(() => location.reload());
      }

      // Cart Script
      function addToCart(productId) {
          fetch("{{ route('cart.add') }}", {
                  method: "POST",
                  headers: {
                      "Content-Type": "application/json",
                      "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                  },
                  body: JSON.stringify({
                      product_id: productId
                  }),
              })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      alert("Product added to cart!");
                  } else {
                      alert("Error: " + data.error);
                  }
              })
              .catch(error => console.error("Error:", error));
      }



    //   Cart Script
    function updateCart(id, quantity) {
        fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id, quantity })
        }).then(() => location.reload());
    }

    function removeFromCart(id) {
        fetch("{{ route('cart.remove') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ id })
        }).then(() => location.reload());
    }

  </script>

  </body>

  </html>