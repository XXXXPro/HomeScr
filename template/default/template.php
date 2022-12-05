<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=$this->settings->title;?></title>
</head>
<body>
  <table>
    <tr>
      <td>
        <h2>Left</h2>
        <?=$blocks['left'];?>
      </td>
      <td>
        <h2>Right</h2>
        <?=$blocks['right'];?>
      </td>
    </tr>
  </table>
</body>
</html>