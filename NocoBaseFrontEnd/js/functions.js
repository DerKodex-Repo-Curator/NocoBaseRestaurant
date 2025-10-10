var redirect_url = "expire.php"; // URL ปลายทางเมื่อหมดเวลา

var buttonPlus = $(".qty-btn-plus");
var buttonMinus = $(".qty-btn-minus");

$(document).on("click", ".qty-btn-plus", function () {
  var $n = $(this).closest(".qty-container").find(".input-qty");
  var qty = Number($n.val());
  $n.val(qty + 1);
  const menuId = $(this).data("menu_id");
  if (menuId) {
    $("#qty_menu_id_" + menuId).val(qty + 1);
  }
});

$(document).on("click", ".qty-btn-minus", function () {
  var $n = $(this).closest(".qty-container").find(".input-qty");
  var amount = Number($n.val());
  const menuId = $(this).data("menu_id");
  if (amount > 0) {
    $n.val(amount - 1);
    if (menuId) {
      $("#qty_menu_id_" + menuId).val(amount - 1);
    }
  }
});

function startCountdown(time_end) {
  // แปลงเวลาหมดอายุเป็น timestamp (รองรับ ISO 8601)
  var countDownDate = new Date(time_end).getTime();
  var countdownEl = document.getElementById("countdown"); // แทน jQuery
  var timer = setInterval(function () {
    var now = new Date().getTime();
    var distance = countDownDate - now;

    if (distance > 0) {
      // แปลงระยะเวลาที่เหลือเป็น ชั่วโมง นาที วินาที
      var hours = Math.floor(
        (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // แสดงผลบนหน้าเว็บ
      countdownEl.textContent = `เหลือเวลาอีก ${hours} ชั่วโมง ${minutes} นาที ${seconds} วินาที`;
    } else {
      // หมดเวลา
      clearInterval(timer);
      //$("#countdown").text("หมดเวลาแล้ว");

      window.location.href = redirect_url;
    }
  }, 1000);
}

function dateTimeToTime(isoString) {
  // แปลงเป็น Date object
  const date = new Date(isoString);

  // แปลงเป็นเวลา (ชั่วโมง:นาที) แบบ 24 ชั่วโมง
  const time = date.toLocaleTimeString("th-TH", {
    hour: "2-digit",
    minute: "2-digit",
    hour12: false,
  });

  return time;
}

var url_api = localStorage.getItem("url_api");
var url_socket = localStorage.getItem("url_socket");
var token = localStorage.getItem("token");
var menus = JSON.parse(localStorage.getItem("menus"));
var order = JSON.parse(localStorage.getItem("order"));
var package = JSON.parse(localStorage.getItem("package"));
