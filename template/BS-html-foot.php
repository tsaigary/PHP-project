      <!-- JavaScript files-->
      <script src="./vendor/jquery/jquery.min.js"></script>
      <script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="./vendor/lightbox2/js/lightbox.min.js"></script>
      <script src="./vendor/nouislider/nouislider.min.js"></script>
      <script src="./vendor/bootstrap-select/js/bootstrap-select.min.js"></script>
      <script src="./vendor/owl.carousel2/owl.carousel.min.js"></script>
      <script src="./vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js"></script>
      <script src="./js/front.js"></script>
      <!-- Nouislider Config-->
      <script>
          var range = document.getElementById('range');
          noUiSlider.create(range, {
              range: {
                  'min': 0,
                  'max': 2000
              },
              step: 5,
              start: [100, 1000],
              margin: 300,
              connect: true,
              direction: 'ltr',
              orientation: 'horizontal',
              behaviour: 'tap-drag',
              tooltips: true,
              format: {
                  to: function(value) {
                      return '$' + value;
                  },
                  from: function(value) {
                      return value.replace('', '');
                  }
              }
          });
      </script>
      <script>
          // ------------------------------------------------------- //
          //   Inject SVG Sprite - 
          //   see more here 
          //   https://css-tricks.com/ajaxing-svg-sprite/
          // ------------------------------------------------------ //
          function injectSvgSprite(path) {

              var ajax = new XMLHttpRequest();
              ajax.open("GET", path, true);
              ajax.send();
              ajax.onload = function(e) {
                  var div = document.createElement("div");
                  div.className = 'd-none';
                  div.innerHTML = ajax.responseText;
                  document.body.insertBefore(div, document.body.childNodes[0]);
              }
          }
          // this is set to BootstrapTemple website as you cannot 
          // inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
          // while using file:// protocol
          // pls don't forget to change to your domain :)
          injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg');
      </script>
      <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      </div>
      </body>

      </html>