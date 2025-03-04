<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
       
    </style>
</head>
<body>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Name</th>
                <th>Age</th>
                <th>Phone Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $people = [
                ['name' => 'John Doe', 'age' => 25, 'phone' => '123-456-7890'],
                ['name' => 'Jane Smith', 'age' => 30, 'phone' => '234-567-8901'],
                ['name' => 'Alice Johnson', 'age' => 22, 'phone' => '345-678-9012'],
                ['name' => 'Chris Lee', 'age' => 28, 'phone' => '456-789-0123'],
                ['name' => 'David Brown', 'age' => 35, 'phone' => '567-890-1234'],
                ['name' => 'Emma Wilson', 'age' => 27, 'phone' => '678-901-2345'],
                ['name' => 'Frank Harris', 'age' => 33, 'phone' => '789-012-3456'],
                ['name' => 'Grace Clark', 'age' => 29, 'phone' => '890-123-4567'],
                ['name' => 'Henry Lewis', 'age' => 31, 'phone' => '901-234-5678'],
                ['name' => 'Ivy Walker', 'age' => 26, 'phone' => '012-345-6789'],
            ];

            foreach ($people as $person) {
                echo "<tr>
                        <td>{$person['name']}</td>
                        <td>{$person['age']}</td>
                        <td>{$person['phone']}</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>