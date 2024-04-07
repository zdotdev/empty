<?php
    $data = './Data/orders.xml';
    $xml = simplexml_load_file($data) or die("Error: Cannot create object");
    if ($xml === false) {
        die("Error: Cannot load XML file.");
    }
    $orders_array = [];
    if (isset($xml->order)) {
        foreach($xml->order as $order) {
            $order_data = [];
            foreach($order->children() as $key => $value) {
                $order_data[$key] = (string)$value;
            }
            $orders_array[] = $order_data;
        }
    } else {
        echo "No orders found.";
    }
    if (isset($_POST['delete_order'])) {
            $order_id = $_POST['order_id'];
            $xml = simplexml_load_file($data);
            if ($xml === false) {
                die("Error: Cannot load XML file.");
            }
            foreach ($xml->order as $order) {
                if ((string) $order->order_id === $order_id) {
                    $dom = dom_import_simplexml($order);
                    $dom->parentNode->removeChild($dom);
                    break;
                }
            }
            $xml->asXML($data);
            header("Location: http://localhost/orderSystem/cashier.php");
            exit();
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier</title>
</head>
<body>
    <div id="container">
        <?php
        foreach ($orders_array as $order_data) {
            echo "
            <div id='card-container'>
                <h2>{$order_data['total_orders']}</h2>
                <p>{$order_data['total_bill']}</p>
                <p>Table number: {$order_data['table_number']}</p>
                <form method='post'>
                    <input type='hidden' name='order_id' value='{$order_data['order_id']}' />
                    <button type='submit' name='delete_order'>Delete</button>
                </form>
            </div>";
        }
        ?>
    </div>
    <script>
        let lastData = '';
        function checkForChanges() {
            fetch('./Data/orders.xml')
                .then(response => response.text())
                .then(data => {
                    if (data !== lastData) {
                        window.location.reload();
                    }
                    lastData = data;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
        function startLongPolling() {
            setInterval(checkForChanges, 3000);
        }
        window.addEventListener('load', () => {
            startLongPolling();
        });
    </script>
</body>
</html>