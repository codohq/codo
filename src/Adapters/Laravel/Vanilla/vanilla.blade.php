<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="codo.adapter" value="laravel" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
</head>
<body>
  <div id="app"></div>

  @vite([
    env('CODO_THEME_ENTRYPOINT', 'src/main.js')
  ])
</body>
</html>
