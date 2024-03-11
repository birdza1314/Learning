<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="offcanvas offcanvas-bottom" id="demo">
  <div class="offcanvas-header">
    <h1 class="offcanvas-title">Heading</h1>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <p>Some text lorem ipsum.</p>
    <button class="btn btn-secondary" type="button">A Button</button>
  </div>
</div>

<div class="container-fluid mt-3">
  <h3>Bottom Offcanvas</h3>
  <p>The .offcanvas-bottom class positions the offcanvas at the bottom of the page.</p>
  <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#demo">
    Toggle Bottom Offcanvas
  </button>
</div>

</body>
</html>
