<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Frontend to Nocobase demo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Noto+Sans+Thai:wght@100..900&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" />
  <style>
    body {
      font-family: "IBM Plex Sans Thai", sans-serif;
      font-weight: 400;
      font-style: normal;
    }

    icon-shape {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      vertical-align: middle;
    }

    .icon-sm {
      width: 2rem;
      height: 2rem;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="row mt-3">
      <div class="col-12">
        <form action="" id="menuList">
          <h3 id="package_name"></h3>
          <div>โต๊ะที่ <span id="table_id"></span> เริ่มเวลา <span id="time_start"></span> ถึง <span id="time_end"></span></div>
          <div>ราคา <span id="package_price"></span> x <span id="num_person"></span> ท่าน = <span id="total_price"></span> บาท</div>
          <div id="countdown"></div>
          <ul class="nav nav-underline nav-fill mb-3" id="underline-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="underline-menus-tab" data-bs-toggle="pill" data-bs-target="#underline-menus" type="button" role="tab" aria-controls="underline-menus" aria-selected="true">เมนู</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="underline-order-history-tab" data-bs-toggle="pill" data-bs-target="#underline-order-history" type="button" role="tab" aria-controls="underline-order-history" aria-selected="false">ประวัติการสั่ง</button>
            </li>
          </ul>
          <div class="tab-content" id="underline-tabContent">
            <div class="tab-pane fade show active" id="underline-menus" role="tabpanel" aria-labelledby="underline-menus-tab" tabindex="0">
              <div class="row overflow-auto g-2 mb-2" id="menus"></div>
              <div class="d-grid mt-auto" style="position: sticky; bottom: 0; z-index: 10; background: white; padding: 0.5rem 0 0.5rem 0;">
                <button type="button" id="preview_order" class="btn btn-success btn-block rounded-0">สั่งอาหาร</button>
              </div>
            </div>
            <div class="tab-pane fade" id="underline-order-history" role="tabpanel" aria-labelledby="underline-order-history-tab" tabindex="0">
              <div class="col-12" id="order_rounds"></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Order Preview Modal -->
  <div class="modal fade" id="orderPreviewModal" tabindex="-1" aria-labelledby="orderPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="orderPreviewModalLabel">กรุณาตรวจสอบรายการ</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row"></div>
        </div>
        <div class="modal-footer border-top-0 justify-content-center">
          <button type="button" class="btn rounded-0 btn-secondary" data-bs-dismiss="modal">กลับไปเลือกเพิ่ม</button>
          <button type="button" class="btn rounded-0 btn-primary" id="confirm_order">ยืนยันรายการ</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Alert Empty Modal -->
  <div class="modal fade" id="alertEmptyModal" tabindex="-1" aria-labelledby="alertEmptyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="orderPreviewModalLabel">กรุณาตรวจสอบรายการ</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">กรุณาระบุจำนวน
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

  <!-- View Menu Modal -->
  <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content rounded-0">
        <div class="modal-header">
          <h5 class="modal-title" id="menuModalLabel">รายละเอียดเมนู</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
        </div>
        <div class="modal-body text-center">
          <img id="menuImage" class="img-fluid rounded-0 mb-3" style="max-height:300px;">
          <h4 id="menuName"></h4>
          <p class="text-muted" id="menuPrice"></p>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.socket.io/4.7.2/socket.io.min.js"></script>
  <script src="js/functions.js"></script>
  <script>
    jQuery(document).ready(function($) {

      var table_id = order.bf_table_id;
      var time_start = order.bf_order_start_time;
      var time_end = order.bf_order_end_time;
      var order_id = order.id;
      var num_person = order.bf_order_num_of_people;
      var package_name = package.bf_package_name;
      var package_price = package.bf_package_price_per_person;
      var total_price = package_price * num_person;

      $("#package_name").text(package_name);
      $("#package_price").text(package_price.toLocaleString());
      $("#total_price").text(total_price.toLocaleString());
      $("#num_person").text(num_person);
      $("#table_id").text(table_id);
      $("#time_start").text(dateTimeToTime(time_start));
      $("#time_end").text(dateTimeToTime(time_end));

      const socket = io(url_socket);

      socket.on("connect", () => {
        console.log("Connected to Socket.io server");
      });

      // tell the socket which order_id belongs to the user currently viewing this page.
      socket.emit("join_order", order_id);

      // recieve event.
      socket.on("order_status_changed", (dataSocket) => {
        if (dataSocket.order_id == order_id && dataSocket.status == "paid") {
          window.location.href = "expire.php";
        }
      });

      document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(event) {
          const targetHash = event.target.getAttribute('data-bs-target'); // "#underline-order-history"
          localStorage.setItem('active_tab', targetHash);
        });
      });

      window.addEventListener('load', function() {
        const savedHash = localStorage.getItem('active_tab');
        if (savedHash) {
          const triggerEl = document.querySelector(`[data-bs-target="${savedHash}"]`);
          if (triggerEl) {
            const tab = new bootstrap.Tab(triggerEl);
            tab.show();
          }
        }
      });


      for (i in menus) {

        const url = menus[i]?.bf_menu_photo?.[0]?.url;
        if (url) {
          var menu_photo = `${url_api}/${url}`;
        } else {
          var menu_photo = "https://placehold.co/200x200?text=No+Image";
        }

        var template = `
        <div class="col-6">
          <div class="card rounded-0">
            <div class="card-body p-1">
              <div class="text-center">
                <p><img src="${menu_photo}" class="img-thumbnail rounded-0 border-0 viewMenu" data-id="${menus[i].id}" /></p>
                <p class="text-dark">${menus[i].bf_menu_name}</p>
              </div>
              <div class="input-group w-auto justify-content-center align-items-center qty-container">
                <input type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 qty-btn-minus" data-field="quantity">
                <input type="text" value="0" name="qty[]" class="quantity-field border-0 text-center input-qty" style="width:35px;" id="qty_menu_id_${menus[i].id}">
                <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm qty-btn-plus" data-field="quantity">
                <input type="hidden" name="item_id[]" value="${menus[i].id}" />
                <input type="hidden" name="bf_menu_name[]" value="${menus[i].bf_menu_name}" />
              </div>
            </div>
          </div>
        </div>`;
        $("#menus").append(template);
      }

      $(document).on("click", ".viewMenu", function() {
        const id = $(this).data("id");
        const menu = menus.find(m => m.id === id);

        if (menu) {
          $("#menuModalLabel").text(menu.bf_menu_name || "ไม่มีชื่อ");
          $("#menuPrice").text(menu.price ? menu.price + " บาท" : "-");
          const photo_url = menu?.bf_menu_photo?.[0]?.url;
          if (photo_url) {
            var menu_photo = `${url_api}/${photo_url}`;
          } else {
            var menu_photo = "https://placehold.co/200x200?text=No+Image";
          }
          $("#menuImage").attr("src", menu_photo);

          const menuModal = document.getElementById('menuModal')
          menuModal.addEventListener('hide.bs.modal', () => {
            if (document.activeElement instanceof HTMLElement) {
              document.activeElement.blur();
            }
          });
          const modalMenu = new bootstrap.Modal(menuModal);
          modalMenu.show();
        }
      });

      startCountdown(time_end);

      $.ajax({
        url: `${url_api}/api/bf_order_rounds:list?filter[order_round_to_orders_id][$eq]=${order.id}`,
        type: "GET",
        dataType: "json",
        headers: {
          Authorization: token,
        },
      }).done(function(success) {
        var dataOR = success.data;

        dataOR.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));

        dataOR.forEach((orderRound, i) => {
          const template = `
          <div class="card mb-3 rounded-0">
            <div class="card-header">
              <h6 class="card-title mb-0 py-1 text-success">สั่งเมื่อเวลา ${dateTimeToTime(orderRound.createdAt)} น.</h6>
            </div>
            <div class="card-body">
              <div class="card-text" id="order_round_${i}"></div>
            </div>
          </div>
          `;
          $("#order_rounds").append(template);

          $.ajax({
            url: `${url_api}/api/bf_order_items:list?filter[order_items_to_orders_round_id][$eq]=${orderRound.id}`,
            type: "GET",
            dataType: "json",
            headers: {
              Authorization: token,
            },
          }).done(function(success) {
            const orderItems = success.data;

            orderItems.forEach((orderItem) => {
              const selectedMenu = menus.find(
                (menu) => menu.id === orderItem.menus_to_order_items_id
              );

              if (selectedMenu) {
                $(`#order_round_${i}`).append(
                  `<div>${selectedMenu.bf_menu_name} x ${orderItem.quantity}</div>`
                );
              }
            });
          });
        });
      });

      $("#preview_order").on("click", function(e) {
        e.preventDefault();

        $("#orderPreviewModal .modal-body .row").html("");

        var form = $("#menuList")[0];
        var formData = new FormData(form);
        var qtys = formData.getAll("qty[]");
        var ids = formData.getAll("item_id[]");
        var totalQty = qtys.reduce((sum, q) => sum + Number(q), 0);
        var bf_menu_name = formData.getAll("bf_menu_name[]"); // สมมติเรามีชื่อเมนู

        if (totalQty === 0) {
          console.log("ไม่มีการสั่งเมนูใด ๆ");
          const alertEmptyModal = document.getElementById('alertEmptyModal')
          alertEmptyModal.addEventListener('hide.bs.modal', () => {
            if (document.activeElement instanceof HTMLElement) {
              document.activeElement.blur();
            }
          });
          const modal = new bootstrap.Modal(alertEmptyModal);
          modal.show();
          return;
        }

        const orderPreviewModal = document.getElementById('orderPreviewModal')
        // orderPreviewModal.addEventListener('shown.bs.modal', () => {
        // });
        orderPreviewModal.addEventListener('hide.bs.modal', () => {
          if (document.activeElement instanceof HTMLElement) {
            document.activeElement.blur();
          }
        });
        const modalOrderPreview = new bootstrap.Modal(orderPreviewModal);
        modalOrderPreview.show();

        const items = ids.map((id, index) => ({
          menus_to_order_items_id: Number(id),
          quantity: Number(qtys[index]),
          bf_menu_name: bf_menu_name[index],
        }));

        var filteredItems = items.filter((item) => item.quantity > 0);

        filteredItems.forEach(item => {
          //var template = `<div>${item.bf_menu_name} x ${item.quantity}</div>`;

          var template = `
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
              <div>
                <p class="text-dark mb-0">${item.bf_menu_name}</p>
              </div>
              <div class="input-group w-auto justify-content-end align-items-center qty-container">
                <input type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 qty-btn-minus" data-field="quantity" data-menu_id="${item.menus_to_order_items_id}">
                <input type="text" value="${item.quantity}" name="qty[]" class="quantity-field border-0 text-center input-qty" style="width:35px;">
                <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm qty-btn-plus" data-field="quantity" data-menu_id="${item.menus_to_order_items_id}">
              </div>
            </div>
          </div>`;
          $("#orderPreviewModal .modal-body .row").append(template);

        });

        $("#confirm_order").off("click").on("click", function() {

          // create round
          $.ajax({
            url: `${url_api}/api/bf_order_rounds`,
            type: 'POST',
            dataType: 'json',
            headers: {
              Authorization: token,
            },
            data: {
              order_round_to_orders_id: order_id
            },
          }).done(function(success) {

            var dataRound = success.data
            var form = $("#menuList")[0];
            var formData = new FormData(form);
            var qtys = formData.getAll("qty[]");
            var ids = formData.getAll("item_id[]");

            var items = ids.map((id, index) => ({
              menus_to_order_items_id: Number(id),
              quantity: Number(qtys[index]),
              bf_menu_name: bf_menu_name[index],
              order_items_to_orders_round_id: dataRound.id
            }));

            var filteredItems = items.filter((item) => item.quantity > 0);

            $.ajax({
              url: `${url_api}/api/bf_order_items`,
              type: 'POST',
              dataType: 'json',
              contentType: 'application/json',
              headers: {
                Authorization: token,
              },
              data: JSON.stringify(filteredItems),
            }).done(function(success) {
              localStorage.setItem('active_tab', '#underline-order-history');
              window.location.href = `menus.php`;
            });
          });
        });

      });

    });
  </script>
</body>

</html>