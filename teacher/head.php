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
  background-color: #cdcccc9e;
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
</style>
</head>
<!-- ======= Head ======= -->