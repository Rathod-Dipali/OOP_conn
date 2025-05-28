<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
    <h5 class="text-success">Rathod Dipali</h5>
    <table class="table">
        <thead>
            <tr>
                <th>
                    Name
                </th>
                <th>
                    Email
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Rathod Dipali
                </td>
                <td>
                    d@gmail.com
                </td>
            </tr>
        </tbody>
    </table>

    <?php
        $str = "hello#world";


        $new_var = explode('#', $str);
        $new_var2 = implode('@', $new_var);
        print_r($new_var2); 
        echo "<br>";
        print_r($new_var);
        exit;
    ?>
</body>
</html>