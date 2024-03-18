<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/normalize.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <link rel="apple-touch-icon" sizes="180x180" href="image/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="image/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="image/favicon-16x16.png">
  <link rel="manifest" href="image/site.webmanifest">
</head>

<body>
  <header class="header">
    <div class="container p-4 header__container">
      <h1 class="text-center header__title">График изменения баланса</h1>
    </div>
  </header>

  <!-- добавим форму выбора файла -->
  <section class="input-form">
    <div class="container input-form__container">
      <form class="form input-form__form" action="" method="get">
        <div class="form-group input-form__wrap">
          <input class="form-control mb-3 input-form__input" type="file" name="file" id="file" />
          <button class="btn btn-primary input-form__btn" type="submit" name="done" value="Построить график изменения баланса">Построить график изменения баланса</button>
          <button class="btn btn-primary input-form__btn btn-warning" type="reset" value="Сбросить">Отменить выбор</button>
        </div>
      </form>
    </div>
  </section>

  <section class="chart">
    <div class="container chart__container">
      <div id="chart" class="chart__out p-3">

        <?php
        $done = $_GET['done'];
        $file = $_GET['file'];

        //блок проверок:
        if (empty($done)) {
          die();
        }

        if (empty($file)) {
          die('<h2 class="alert alert-danger text-center">Ошибка! Файл не выбран!</h2>');
        }

        if (pathinfo($file, PATHINFO_EXTENSION) !== 'html') {
          die('<h2 class="alert alert-danger text-center">Ошибка! Файл должен быть формата .html!</h2>');
        }

        require_once 'parser.php'; //подключаем парсер

        if (!$trueFile) {
          die("<h5 class='alert alert-danger text-center'>Ошибка! Не верный формат отчета" . "<br>");
        }
        ?>

        <h4 class="text-center chart__title"> Отчет
          <?php
          echo 'из файла: ' . $_GET['file'];
          ?>
        </h4>
      </div>
    </div>
  </section>

  <section class="chart">
    <div class="container chart__container">
      <div>
        <canvas id="myChart"></canvas>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <script>
        const labels = [<?php echo '"' . implode('","', $parcArreyDate) . '"' ?>];
        const data = [<?php echo '"' . implode('","', $parcArreyDinamic) . '"' ?>];
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [{
              label: 'Динамика изменения баланса',
              data: data,
              backgroundColor: [
                'rgba(13, 110, 253, 1)',
              ],
              borderColor: [
                'rgba(13, 110, 253, 1)',
              ],
              borderWidth: 1,
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: false,
              }
            }
          }
        });
      </script>
    </div>
  </section>
</body>

</html>