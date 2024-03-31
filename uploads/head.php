
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar</title>
  <!-- Bootstrap CSS -->
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <style>
  /* กำหนดสไตล์เฉพาะ */
.navbar-custom {
  background-color: #ffffff; /* สีพื้นหลัง Navbar */
}

.navbar-brand-custom {
  width: 250px; /* ความกว้างโลโก้ */
  height: auto; /* ปรับความสูงโลโก้ให้ปรับตามความกว้าง */
}

/* สีข้อความ Navbar brand */
.navbar-brand {
  color: #333; /* สีข้อความ */
}

/* สีไอคอน Navbar toggler */
.navbar-toggler-icon {
  color: #333; /* สีไอคอน */
}

/* สีลิงก์ใน Navbar */
.navbar-nav .nav-link {
  color: #333; /* สีลิงก์ */
}

/* สีลิงก์เมื่อโฮเวอร์ */
.navbar-nav .nav-link:hover {
  color: #007bff; /* สีเมื่อโฮเวอร์ */
}

/* สีลิงก์ที่เปิดอยู่ */
.navbar-nav .nav-item.active .nav-link {
  color: #007bff; /* สีลิงก์ที่เปิด */
}

/* สีพื้นหลังเมนู Dropdown */
.dropdown-menu {
  background-color: #f8f9fa; /* สีพื้นหลังเมนู Dropdown */
}

/* สีข้อความเมนู Dropdown */
.dropdown-item {
  color: #333; /* สีข้อความเมนู Dropdown */
}

/* สีเมื่อโฮเวอร์เมนู Dropdown */
.dropdown-item:hover {
  background-color: #007bff; /* สีพื้นหลังเมื่อโฮเวอร์เมนู Dropdown */
  color: #fff; /* สีข้อความเมื่อโฮเวอร์เมนู Dropdown */
}

/* เงาขอบ Navbar เมื่อ sticky */
.navbar.sticky-top {
  box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* เงา */
}


        /* กำหนดสไตล์ของการ์ด */
    .card {
      border-radius: 10px; /* มนัสเว้นรอบขอบ */
      box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* เงา */
      background-color: #f8f9fa;
    }

    /* กำหนดสไตล์ของหัวข้อ */
    .card-title h3 {
      font-family: 'Arial', sans-serif; /* แบบอักษร */
      color: #333; /* สีข้อความ */
      margin: 0; /* ขอบมาศุนเป็น 0 */
    }

    /* กำหนดสไตล์ของรูปภาพในการ์ด */
    .card-body img {
      width: 80%; /* ความกว้างของรูปภาพ */
      border-radius: 10px; /* มนัสเว้นรอบขอบ */
      transition: transform 0.3s ease; /* เริ่มทำงานอนิเมชันเมื่อโฮเวอร์ */
    }

    /* อนิเมชันเมื่อโฮเวอร์กับรูปภาพ */
    .card-body img:hover {
      transform: scale(1.05); /* ขยายรูปภาพเล็กน้อยเมื่อโฮเวอร์ */
    }

    /* ปุ่ม "รายวิชาทั้งหมด" */
    .py-4 .btn {
      border-color: #007bff; /* สีขอบปุ่ม */
      color: #007bff; /* สีข้อความ */
    }

    /* สไตล์เมื่อโฮเวอร์กับปุ่ม */
    .py-4 .btn:hover {
      background-color: #007bff; /* สีพื้นหลังเมื่อโฮเวอร์ */
      color: #fff; /* สีข้อความเมื่อโฮเวอร์ */
    }

    /* อิ่มตัวแถวเพื่อให้รูปภาพอยู่ตรงกลาง */
    .d-flex {
      display: flex; /* ใช้ flexbox */
      justify-content: center; /* จัดการตำแหน่งแนวนอน */
      align-items: center; /* จัดการตำแหน่งแนวตั้ง */
    }
    .carousel-caption {
    top: 550px;
      text-align: center; /* จัดข้อความให้อยู่ตรงกลาง */
      color: #fff; /* สีข้อความ */
    }
    .carousel-caption .btn {
      background-color: #ffffff; /* สีพื้นหลัง */
      color: #007bff; /* สีข้อความ */
      font-size: 24px; /* ขนาดฟอนต์ */
      font-weight: bold; /* ทำให้ตัวอักษรหนาขึ้น */
      padding: 15px 30px; /* ขนาดของ padding */
      border: 2px solid #007bff; /* ขนาดของเส้นขอบ */
    }

    .carousel-caption .btn:hover {
      background-color: #007bff; /* สีพื้นหลังเมื่อโฮเวอร์ */
      color: #ffffff; /* สีข้อความเมื่อโฮเวอร์ */
    }
    .carousel-caption h1 {
      font-family: 'Arial', sans-serif; /* แบบอักษร */
      font-size: 36px; /* ขนาดฟอนต์ของส่วนหัว */
      color: #000; /* สีข้อความของส่วนหัว */
      font-weight: bold; /* ทำให้ข้อความของส่วนหัวหนาขึ้น */
    }

    .carousel-caption h4 {
      font-family: 'Arial', sans-serif; /* แบบอักษร */
      font-size: 18px; /* ขนาดฟอนต์ของส่วนเนื้อหา */
      color: #000; /* สีข้อความของส่วนเนื้อหา */
      line-height: 1.6; /* ความสูงของบรรทัด */
    }
    .carousel-caption img {
  max-width: 100px;
  height: auto;
  object-fit: contain; /* ปรับขนาดรูปให้พอดีกับพื้นที่ */
}

    /* Media queries เพื่อทำให้หน้าเว็บ responsive */
    @media (max-width: 767px) {
      /* ปรับขนาดของภาพให้เต็มกว้างในขนาดหน้าจอเล็ก */
      .card-body img {
        width: 100%;
      }
    }
/* Customize Card Style */
.card {
            border: none;
            border-radius: 15px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 150px;
            object-fit: cover;
        }

  </style>
</head>
