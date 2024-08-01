<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Admin Page</title>

  <!-- ICON -->

  <link rel="icon" type="image/png" sizes="16x16" href="/images/logo.png">

  <!-- FONTS -->
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
  <!-- Inter -->

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

  <!-- ICON CDN -->

  <!-- FONTAWESOME -->

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

  @vite('resources/css/app.css')
</head>
<body>
  <div class="font-inter w-full h-screen bg-adminMain">
    @yield('content')
  </div>
</body>
</html>