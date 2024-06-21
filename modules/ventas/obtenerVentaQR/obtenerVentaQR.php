<?php
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function generarQrMercadoPago($totalAmount)
    {

        $url = 'https://api.mercadopago.com/instore/orders/qr/seller/collectors/1016800935/pos/proyectoTienda001POS001/qrs';
        $token = 'TEST-8860085067854497-062015-fc65fdea517cab3262f17d73ebdb47e4-1016800935';

        $data = [
            "cash_out" => ["amount" => 0],
            "external_reference" => "reference_12345",
            "total_amount" => $totalAmount,
            "notification_url" => "https://www.yourserver.com/notifications",
            "title" => "Compra en Mi Tienda",
            "description" => "Compra y Retiro",
            "items" => [
                [
                    "sku_number" => "A123K9191938",
                    "category" => "marketplace",
                    "title" => "Compra",
                    "description" => "Compra de Productos",
                    "unit_price" => $totalAmount,
                    "quantity" => 1,
                    "unit_measure" => "unit",
                    "total_amount" => $totalAmount
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return ['success' => false, 'message' => 'Request Error:' . curl_error($ch)];
        }
        curl_close($ch);

        $response_data = json_decode($response, true);
        return $response_data;
    }

    $totalAmount = (isset($_POST['total_amount'])) ? $_POST['total_amount'] : 10;
    $totalAmount = intval($totalAmount);
    // $totalAmount = $_POST['total_amount'];
    $respuesta = generarQrMercadoPago($totalAmount);
    // var_dump($respuesta);
    // echo $respuesta['qr_data'];

    header('Content-Type: application/json');
    echo json_encode($respuesta['qr_data']);
// }
?>