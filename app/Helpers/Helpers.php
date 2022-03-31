<?php
//
//use Domain\Products\States\Order\Accepted;
//use Domain\Products\States\Order\Cancelled;
//use Domain\Products\States\Order\Disputed;
//use Domain\Products\States\Order\Ordered;
//use Domain\Products\States\Order\Refunded;
//use Domain\Products\States\Order\Rejected;
//use Domain\Products\States\Order\Shipped;
use Carbon\Carbon;

//use Illuminate\Support\Facades\Http;

//if (! function_exists('convert_currency')) {
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

if(!function_exists('format_cur')) {
    function format_cur(float $value, int $decimals = 0, string $currency = 'KES')
    {
        if($value < 1 & $decimals == 0) $decimals = 1;

        $fmt = numfmt_create('en', NumberFormatter::CURRENCY);
        $fmt->setAttribute(NumberFormatter::FRACTION_DIGITS, $decimals);

        return numfmt_format_currency($fmt, $value, $currency);
    }
}

if(!function_exists('local_date')) {
    /**
     * Format a date to the users local timezone with an optional format
     *
     * @param string|Carbon $date
     * @param string        $format
     * @return string|null
     */
    function local_date(Carbon|string $date, string $format = 'n/j/Y'): ?string
    {
        if(!$date) return null;

        if(!$date instanceof Carbon) {
            $date = new Carbon($date);
        }

        $date->setTimezone(session('timezone') ?? 'Africa/Nairobi');

        return $date->format($format);
    }
}

if(!function_exists('nav_link_active')) {
    function nav_link_active($pattern): string
    {
        return Route::is($pattern)
            ? 'active'
            : '';
    }
}

if(!function_exists('base_64_url_encode')) {
    function base_64_url_encode($text): array|string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }
}

if(!function_exists('"get_initials')) {
    function get_initials(string $words): string
    {
        $words = explode(" ", $words);
        $acronym = "";

        foreach ($words as $w) $acronym .= strtoupper($w[0] ?? "");

        return $acronym;
    }
}
