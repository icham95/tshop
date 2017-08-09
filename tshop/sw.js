var versionCache = 'tshop-v6';
var toCache = [
        '/',
        // 'index.php',
        // 'https://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100',
        'http://localhost/tshop/tshop/views/css/font-awesome.css',
        'http://localhost/tshop/tshop/views/css/bootstrap.min.css',
        'http://localhost/tshop/tshop/views/css/animate.min.css',
        'http://localhost/tshop/tshop/views/css/owl.carousel.css',
        'http://localhost/tshop/tshop/views/css/owl.theme.css',
        'http://localhost/tshop/tshop/views/css/style.default.css',
        'http://localhost/tshop/tshop/views/css/custom.css',
        'http://localhost/tshop/tshop/views/js/respond.min.js',
        'http://localhost/tshop/tshop/views/js/jquery-1.11.0.min.js',
        'http://localhost/tshop/tshop/views/js/bootstrap.min.js',
        'http://localhost/tshop/tshop/views/js/jquery.cookie.js',
        'http://localhost/tshop/tshop/views/js/waypoints.min.js',
        'http://localhost/tshop/tshop/views/js/modernizr.js',
        'http://localhost/tshop/tshop/views/js/bootstrap-hover-dropdown.js',
        'http://localhost/tshop/tshop/views/js/owl.carousel.min.js',
        'http://localhost/tshop/tshop/views/js/front.js',
        // 'https://fonts.gstatic.com/s/roboto/v16/CWB0XYA8bzo0kSThX0UTuA.woff2',
        // 'https://fonts.gstatic.com/s/roboto/v16/d-6IYplOFocCacKzxwXSOFtXRa8TVwTICgirnJhmVJw.woff2',
        'http://localhost/tshop/tshop/views/css/fonts/fontawesome-webfont.woff?v=4.0.3',
        // 'https://fonts.gstatic.com/s/roboto/v16/RxZJdnzeo3R5zSexge8UUVtXRa8TVwTICgirnJhmVJw.woff2',
        // 'https://fonts.gstatic.com/s/roboto/v16/Hgo13k-tfSpn0qi1SFdUfVtXRa8TVwTICgirnJhmVJw.woff2'
      ];

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request).then(function (response) {
      if (response) {
        return response
      } else {
        return fetch(event.request).then(function(response) {
          if (response.status == 404) {
            return new Response('404 not found')
          }
          return response
        })
      }
    })
  )
})

self.addEventListener('install', function (event) {
  event.waitUntil(
    caches.open(versionCache).then(function(cache) {
      return cache.addAll(toCache)
    }).catch(function (err) {
      console.log('error : ' + err)
    })
  )
})