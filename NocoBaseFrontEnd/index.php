<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bootstrap demo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" />
</head>

<body>
  <div class="container">
  </div>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/functions.js"></script>
  <script>
    jQuery(document).ready(function($) {

      const token = "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOjEsInJvbGVOYW1lIjoibWVtYmVyIiwiaWF0IjoxNzYwMDg0MzEzLCJleHAiOjMzMzE3Njg0MzEzfQ.dc50iGWwW9xCBFlxQaRi7Mpd159Lt9mnyRVkrLrJ0Ig";
      const url_api = "http://localhost:13000";
      const url_socket = "http://localhost:3001"
      const url_params = new URLSearchParams(window.location.search);
      const order_id = url_params.get("order_id");

      $.ajax({
        url: `${url_api}/api/bf_menus?filter[bf_menu_is_available][$eq]=available&appends[]=bf_menu_photo`,
        type: "GET",
        dataType: "json",
        headers: {
          Authorization: token,
        },
      }).done(function(success) {
        var dataMenus = success.data;

        const sortedMenus = dataMenus.sort((a, b) => a.bf_menu_sort - b.bf_menu_sort);

        $.ajax({
          url: `${url_api}/api/bf_orders:list?filter[id][$eq]=${order_id}`,
          type: 'GET',
          dataType: 'json',
          headers: {
            Authorization: token,
          },
        }).done(function(success) {
          var dataOrder = success.data[0];

          $.ajax({
            url: `${url_api}/api/bf_packages:list?filter[id][$eq]=${dataOrder.bf_packages_to_order_id}`,
            type: 'GET',
            dataType: 'json',
            headers: {
              Authorization: token,
            },
          }).done(function(success) {
            var dataPackage = success.data[0];
            var time_end = dataOrder.bf_order_end_time;
            var now = new Date().getTime();
            var end = new Date(time_end).getTime();
            localStorage.setItem("url_api", url_api);
            localStorage.setItem("url_socket", url_socket);
            localStorage.setItem("token", token);
            localStorage.setItem("menus", JSON.stringify(sortedMenus));
            localStorage.setItem("order", JSON.stringify(dataOrder));
            localStorage.setItem("package", JSON.stringify(dataPackage));
            if (end > now) {
              window.location.href = "menus.php";
            } else {
              window.location.href = "expire.php";
            }
          });

        });
      });

    });
  </script>
</body>

</html>