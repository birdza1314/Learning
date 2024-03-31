<!-- ======= Head ======= -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="css/style.css" rel="stylesheet">
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>



<style>
  .description-column {
    max-height: 5px; /* ปรับค่าตามที่ต้องการ */
    max-width: 5px;
    overflow-y: auto;
    white-space: nowrap;
  }
  body {
  font-family: "Open Sans", sans-serif;
  background-color: #e1eafc;
 }

</style>
<style>
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-group input[type="file"] {
            width: calc(100% - 100px);
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
        /* Accordion */
    .accordion-item {
      border: 1px solid #b5b5b5; 
    }

    .accordion-button:focus {
      outline: 0;
      box-shadow: none;
    }

    .accordion-button:not(.collapsed) {
      color: #012970;
      background-color: #f6f9ff;
    }

    .accordion-flush .accordion-button {
      padding: 15px 0;
      background: none;
      border: 0;
    }

    .accordion-flush .accordion-button:not(.collapsed) {
      box-shadow: none;
      color: #4154f1;
    }

    .accordion-flush .accordion-body {
      padding: 0 0 15px 0;
      color: #3e4f6f;
      font-size: 15px;
    }
    .dropdown-menu {
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
      padding: 0.5rem 1rem;
    }

    .dropdown-item:hover {
      background-color: #f2f2f2;
    }
    .badge {
        font-weight: bold;
        text-transform: uppercase;
        padding: 5px 10px;
        min-width: 19px;
    }
    .badge-primary {
        color: #fff;
        background-color: #02e60a;
    }
    .scrollbar-container {
        overflow: auto;
    }
    .scrollbar-container {
        max-height: 400px; /* ความสูงสูงสุดของตาราง */
        overflow-y: auto; /* เลื่อนในแนวตั้ง */
    }
   
  .card-format {
    display: none;
  }

    .card-img-top {
        width: 100%;
        height: 200px; /* ปรับความสูงตามที่ต้องการ */
        object-fit: cover; /* จัดการขนาดรูปภาพ */
    }
    .description-card {
        height: 100px; /* ปรับความสูงตามที่ต้องการ */
        overflow: hidden; /* ซ่อนเนื้อหาที่เกินขอบเขต */
    }
    .td-button {
    display: flex;
    align-items: center;
    justify-content: center;
}

</style>
<style>
  .hover-effect:hover {
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    transform: translateY(-3px);
    background-color: #a3bdd9;
  }
  .text-hover-white:hover {
  color: #ffffff;
  }
  .hover-zoom {
      overflow: hidden;
    }

    .hover-zoom img {
      transition: transform 0.3s ease-in-out;
    }

    .hover-zoom:hover img {
      transform: scale(1.2); /* Adjust zoom factor as needed */
    }
    /*--------------------------------------------------------------
  # Header Nav
  --------------------------------------------------------------*/
  .header-nav ul {
    list-style: none;
  }

  .header-nav>ul {
    margin: 0;
    padding: 0;
  }

  .header-nav .nav-icon {
    font-size: 22px;
    color: #012970;
    margin-right: 25px;
    position: relative;
  }

  .header-nav .nav-profile {
    color: #012970;
  }

  .header-nav .nav-profile img {
    max-height: 36px;
  }

  .header-nav .nav-profile span {
    font-size: 14px;
    font-weight: 600;
  }

  .header-nav .badge-number {
    position: absolute;
    inset: -2px -5px auto auto;
    font-weight: normal;
    font-size: 12px;
    padding: 3px 6px;
  }

  .header-nav .notifications {
    inset: 8px -15px auto auto !important;
  }

  .header-nav .notifications .notification-item {
    display: flex;
    align-items: center;
    padding: 15px 10px;
    transition: 0.3s;
  }

  .header-nav .notifications .notification-item i {
    margin: 0 20px 0 10px;
    font-size: 24px;
  }

  .header-nav .notifications .notification-item h4 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
  }

  .header-nav .notifications .notification-item p {
    font-size: 13px;
    margin-bottom: 3px;
    color: #919191;
  }

  .header-nav .notifications .notification-item:hover {
    background-color: #f6f9ff;
  }

  .header-nav .messages {
    inset: 8px -15px auto auto !important;
  }

  .header-nav .messages .message-item {
    padding: 15px 10px;
    transition: 0.3s;
  }

  .header-nav .messages .message-item a {
    display: flex;
  }

  .header-nav .messages .message-item img {
    margin: 0 20px 0 10px;
    max-height: 40px;
  }

  .header-nav .messages .message-item h4 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #444444;
  }

  .header-nav .messages .message-item p {
    font-size: 13px;
    margin-bottom: 3px;
    color: #919191;
  }

  .header-nav .messages .message-item:hover {
    background-color: #f6f9ff;
  }

  .header-nav .profile {
    min-width: 240px;
    padding-bottom: 0;
    top: 8px !important;
  }

  .header-nav .profile .dropdown-header h6 {
    font-size: 18px;
    margin-bottom: 0;
    font-weight: 600;
    color: #444444;
  }

  .header-nav .profile .dropdown-header span {
    font-size: 14px;
  }

  .header-nav .profile .dropdown-item {
    font-size: 14px;
    padding: 10px 15px;
    transition: 0.3s;
  }

  .header-nav .profile .dropdown-item i {
    margin-right: 10px;
    font-size: 18px;
    line-height: 0;
  }

  .header-nav .profile .dropdown-item:hover {
    background-color: #f6f9ff;
  }

</style>
<style>
 /* ปรับแต่ง dropdown menu */
.dropdown-menu1 {
  background-color: #fff;
  border-radius: 0.5rem;
  box-shadow: 0 0.1rem 0.2rem rgba(0, 0, 0, 0.1);
  min-width: 20rem;
  z-index: 1000;
}

/* ปรับแต่ง header ของ dropdown menu */
.dropdown-header1 {
  font-size: 0.8rem;
  font-weight: bold;
  padding: 0.5rem 1rem;
  color: #333;
  border-bottom: 1px solid #ddd;
}

/* ปรับแต่ง badge แสดงจำนวน notification */
.badge1 {
  font-size: 0.7rem;
  font-weight: normal;
  padding: 0.3rem 0.5rem;
  border-radius: 0.25rem;
  background-color: #dc3545; /* เปลี่ยนสี badge */
}

/* ปรับแต่ง notification item */
.notification-item1 {
  padding: 0.5rem 1rem;
  cursor: pointer;
  transition: all 0.2s ease-in-out;
  border-bottom: 1px solid #ddd;


}
    /* Media queries เพื่อทำให้หน้าเว็บ responsive */
    @media (max-width: 767px) {
      /* ปรับขนาดของภาพให้เต็มกว้างในขนาดหน้าจอเล็ก */
      .card-body img {
        width: 100%;
      }
    }
    
</style>
</head>
<!-- ======= Head ======= -->