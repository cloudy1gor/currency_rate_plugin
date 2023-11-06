<?php
/*
Plugin Name: Currency Rate
Description: Plugin to display currency exchange rates.
Version: 1.0
*/

function currency_rate_shortcode($atts) {
    $atts = shortcode_atts( array(
        'from' => 'usd',
        'to' => 'uah'
    ), $atts );

    // API Приватбанка з актуальним курсом валют
    $url = 'https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5';

    // Отримання даних через cURL
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);

    $result = '';

    // Перевірка наявності даних та їх виведення
    if ($data) {
        $currency_data = json_decode($data, true);
        // Перегляд курсів валют
        foreach ($currency_data as $currency) {
            $result .= $currency['ccy'] . ' до ' . $currency['base_ccy'] . ': ' . $currency['buy'] . '<br>';
        }
    } else {
        $result = 'Не вдалося отримати дані про курси валют';
    }

    // Закриття cURL-з'єднання
    curl_close($curl);

    return $result;
}

// Реєструю шорткод
add_shortcode('currency_rate', 'currency_rate_shortcode');