<?php
    $data = './Data/data.xml';
    $xml = simplexml_load_file($data) or die("Error: Cannot create object");
    $meal_array = [];
    foreach($xml->meals->children() as $food) {
        $food_data = [];
        foreach($food->children() as $key => $value) {
            $food_data[$key] = (string)$value;
        }
        $meal_array[] = $food_data;
    }
    $snacks_array = [];
    foreach($xml->snacks->children() as $food) {
        $food_data = [];
        foreach($food->children() as $key => $value) {
            $food_data[$key] = (string)$value;
        }
        $snacks_array[] = $food_data;
    }
    $beverages_array = [];
    foreach($xml->beverages->children() as $food) {
        $food_data = [];
        foreach($food->children() as $key => $value) {
            $food_data[$key] = (string)$value;
        }
        $beverages_array[] = $food_data;
    }
    $sweets_array = [];
    foreach($xml->sweets->children() as $food) {
        $food_data = [];
        foreach($food->children() as $key => $value) {
            $food_data[$key] = (string)$value;
        }
        $sweets_array[] = $food_data;
    }
    $random_letters = substr(str_shuffle("abcdefghijklmnopqrstuvwxyz"), 0, 5);
    if(isset($_POST['save_order'])) {
        $totalOrders = $_POST['total_orders'];
        $totalBill = $_POST['total_bill'];
        $table = $_GET['table'] ?? '';
        $ordersFile = './Data/orders.xml';
        if (file_exists($ordersFile)) {
            $ordersXml = simplexml_load_file($ordersFile) or die("Error: Cannot create object");
        } else {
            $ordersXml = new SimpleXMLElement('<?xml version="1.0"?><orders></orders>');
        }
        $order = $ordersXml->addChild('order');
        $order->addChild('total_orders', $totalOrders);
        $order->addChild('total_bill', $totalBill);
        $order->addChild('table_number', $table);
        $order->addChild('order_id', $random_letters);
        $ordersXml->asXML($ordersFile);
        header("Location: http://localhost/orderSystem/landing.php?table={$table}&orderId=$random_letters");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./Style/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <title>Ordering System</title>
        <script src="./JavaScript/main.js" defer></script>
    </head>
    <body>
        <nav class="header-container">
            <a href="#" class="header-logo">Yow MSC!</a>
            <h1 class="header-title">MARSERVE</h1>
            <div class="search-div">
                <input type="text" id='search-input' placeholder="Search?">
                <a class="search-button">Search</a>
            </div>
        </nav>
        <main>
            <div class="sidebar-container">
                <div>
                    <h2 class="sidebar-title">Foods and Beverages:</h2>
                    <ul class="sidebar-ul">
                        <li><a href="#meals" class="sidebar-li">Meals</a></li>
                        <li><a href="#snacks" class="sidebar-li">Snacks</a></li>
                        <li><a href="#beverages" class="sidebar-li">Beverages</a></li>
                        <li><a href="#sweets" class="sidebar-li">Sweets</a></li>
                    </ul>
                </div>
                <div class="sidebar-receipt">
                    <p class="sidebar-receipt-title">Receipt:</p>
                    <p class="total-orders">Total orders: <span id="total-orders"></span></p>
                    <p class="total-bill">Total bill: <span id="total-bill"></span> php</p>
                    <form id="save-order-form" action="" method="post">
                        <input type="hidden" name="total_orders" id="total-orders-input">
                        <input type="hidden" name="total_bill" id="total-bill-input">
                        <button type="submit" name="save_order" id="save-order-btn">Place Order</button>
                        <button type="button" id="show-orders">Show Orders</button>
                    </form>
                </div>
            </div>
            <div id="container">
                <div class="sub-container">
                    <section id="meals">
                        <h2 class="f-title">Meals:</h2>
                        <div class="f-container">
                            <?php
                                foreach ($meal_array as $meal_data) {
                                    echo "
                                    <div id='card-container' data-description='{$meal_data['description']}' data-price='{$meal_data['price']}' data-name='{$meal_data['name']}' data-image='{$meal_data['image']}'>
                                        <span id='{$meal_data['name']}'></span>
                                        <img src='./Image/{$meal_data['image']}' alt='{$meal_data['id']}' class='food-image'>
                                        <h2 class='food-title'>{$meal_data['name']}</h2>
                                        <p class='order-count' id='order-count-{$meal_data['name']}'></p>
                                        <h3 class='food-price'>Price: {$meal_data['price']} php</h3>
                                    </div>";
                                }
                            ?>
                        </div>
                    </section>
                    <section id="snacks">
                        <h2 class="f-title">Snacks:</h2>
                        <div class="f-container">
                            <?php
                                foreach ($snacks_array as $snack_data) {
                                    echo "
                                    <div id='card-container' data-description='{$snack_data['description']}' data-price='{$snack_data['price']}' data-name='{$snack_data['name']}' data-image='{$snack_data['image']}'>
                                        <span id='{$snack_data['name']}'></span>
                                        <img src='./Image/{$snack_data['image']}' alt='{$snack_data['id']}' class='food-image'>
                                        <h2 class='food-title'>{$snack_data['name']}</h2>
                                        <p class='order-count' id='order-count-{$snack_data['name']}'></p>
                                        <h3 class='food-price'>Price: {$snack_data['price']} php</h3>
                                    </div>";
                                }
                            ?>
                        </div>
                    </section>
                    <section id="beverages">
                        <h2 class="f-title">Beverages:</h2>
                        <div class="f-container">
                            <?php
                                foreach ($beverages_array as $beverage_data) {
                                    echo "
                                    <div id='card-container' data-description='{$beverage_data['description']}' data-price='{$beverage_data['price']}' data-name='{$beverage_data['name']}' data-image='{$beverage_data['image']}'>
                                        <span id='{$beverage_data['name']}'></span>
                                        <img src='./Image/{$beverage_data['image']}' alt='{$beverage_data['id']}' class='food-image'>
                                        <h2 class='food-title'>{$beverage_data['name']}</h2>
                                        <p class='order-count' id='order-count-{$beverage_data['name']}'></p>
                                        <h3 class='food-price'>Price: {$beverage_data['price']} php</h3>
                                    </div>";
                                }
                            ?>
                        </div>
                    </section>
                    <section id="sweets">
                        <h2 class="f-title">Sweets:</h2>
                        <div class="f-container">
                            <?php
                                foreach ($sweets_array as $sweet_data) {
                                    echo "
                                    <div id='card-container' data-description='{$sweet_data['description']}' data-price='{$sweet_data['price']}' data-name='{$sweet_data['name']}' data-image='{$sweet_data['image']}'>
                                        <span id='{$sweet_data['name']}'></span>
                                        <img src='./Image/{$sweet_data['image']}' alt='{$beverage_data['id']}' class='food-image'>
                                        <h2 class='food-title'>{$sweet_data['name']}</h2>
                                        <p class='order-count' id='order-count-{$sweet_data['name']}'></p>
                                        <h3 class='food-price'>Price: {$sweet_data['price']} php</h3>
                                    </div>";
                                }
                            ?>
                        </div>
                    </section>
                </div>
            </div>
        </main>
        <dialog id="dialog">
            <div class="dialog-div">
                <img id="dialog-food-image" alt="food_image">
                <h3 id="dialog-food-name"></h3>
                <p class="df-price">Price: <span id="dialog-food-price"></span></p>
                <p id="dialog-food-description"></p>
                <div class="dialog-incredecre">
                    <button id="decrement">-</button>
                    <p>Order Count: <span id="order-count"></span></p>
                    <button id="increment">+</button>
                </div>
            </div>
            <span class="dialog-food-span">
                <button id="add">Add</button>
                <button id="close-button">Close</button>
            </span>
        </dialog>
        <button id='contact-us' class="contact-us material-symbols-outlined">question_mark</button>
        <script>
            document.getElementById('contact-us').addEventListener('click', () => {
            let currentUrl = window.location.href
            let url = new URL(currentUrl)
            let oi = url.searchParams.get('orderId')
            let table = url.searchParams.get('table')
            window.location.href = `http://localhost/orderSystem/profile.php?orderId=${oi}&table=${table}`
            })
        </script>
    </body>
</html>
