<?php
//
//use Domain\Products\States\Order\Accepted;
//use Domain\Products\States\Order\Cancelled;
//use Domain\Products\States\Order\Disputed;
//use Domain\Products\States\Order\Ordered;
//use Domain\Products\States\Order\Refunded;
//use Domain\Products\States\Order\Rejected;
//use Domain\Products\States\Order\Shipped;
use Illuminate\Support\Facades\Cache;

//use Illuminate\Support\Facades\Http;

//if (! function_exists('convertCurrency')) {
//    function convert_currency(string $currency)
//    {
//        $response = Cache::remember('currencies_' . $currency, 21600, function () use ($currency) {
//            $res = Http::withHeaders([
//                'accept' => 'application/json',
//            ])->get(env('CURRENCYLAYER_URL'), [
//                'access_key' => env('CURRENCYLAYER_API_KEY'),
//                'currencies' => $currency,
//            ]);
//
//            return $res->json()['quotes'];
//        });
//
//        $quote = 'USD' . $currency;
//
//        return (float)$response[$quote];
//    }
//}

if (!function_exists('format_cur')) {
    function format_cur(float $value, int $decimals = 0, string $currency = 'KES')
    {
        if ($value < 1 & $decimals == 0)
            $decimals = 1;

        $fmt = numfmt_create('en', NumberFormatter::CURRENCY);
        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);

        return numfmt_format_currency($fmt, $value, $currency);
    }
}


//if (! function_exists('get_state')) {
//    function get_state(string $status) {
//        switch (strtoupper($status)) {
//            case "ACCEPTED":
//                return Accepted::class;
//
//            case "CANCELLED":
//                return Cancelled::class;
//
//            case "DISPUTED":
//                return Disputed::class;
//
//            case "REFUNDED":
//                return Refunded::class;
//
//            case "REJECTED":
//                return Rejected::class;
//
//            case "SHIPPED":
//                return Shipped::class;
//
//            case "ORDERED":
//                return [Ordered::class];
//
//            default:
//                return [Ordered::class, Accepted::class, Cancelled::class, Disputed::class, Refunded::class, Rejected::class, Shipped::class];
//        }
//    }
//}

?>
