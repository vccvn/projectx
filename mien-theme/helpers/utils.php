<?php

use App\Web\Data;

if (!function_exists('get_contact_phone')) {
    function get_contact_phone()
    {
        static $phone = null;
        if(!$phone){
            $phone = get_web_data('options')->theme->contacts->phone_number(siteinfo()->phone_number);
        }
        return $phone;
    }
}
if (!function_exists('mien_add_schema_data')) {
    function mien_add_schema_data($data)
    {
        set_web_data('mien_json_schema_data', $data);
    }
}
if (!function_exists('mien_get_schema_data')) {
    function mien_get_schema_data()
    {
        if(!is_array($data = get_web_data('mien_json_schema_data'))) $data = [];
        return $data;
    }
}

if (!function_exists('mien_add_product_schema')) {
    function mien_add_product_schema($product)
    {
        $images = [$product->getImage()];
        if ($product->gallery && count($product->gallery)){
            foreach ($product->gallery as $item){
                $images[] = $item->url;
            }
        }
        mien_add_schema_data([
            "@context" => "https://schema.org/",
            "@type" => "Product",
            "name" => $product->name,
            "image" => $images,
            "description" => $product->description,
            "sku" => $product->sku,
            // "mpn" => "925872",
            "brand" => [
                "@type" => "Brand",
                "name" => "ACME"
            ],
            "review" => [
                "@type" => "Review",
                "reviewRating" => [
                    "@type" => "Rating",
                    "ratingValue" => "4",
                    "bestRating" => "5"
                ],
                "author" => [
                    "@type" => "Person",
                    "name" => "Fred Benson"
                ]
            ],
            "aggregateRating" => [
                "@type" => "AggregateRating",
                "ratingValue" => "4.4",
                "reviewCount" => "89"
            ],
            "offers" => [
                "@type" => "Offer",
                "url" => $product->getViewUrl(),
                "priceCurrency" => "VND",
                "price" => $product->final_price,
                "priceValidUntil" => "2020-11-20",
                "itemCondition" => "https://schema.org/UsedCondition",
                "availability" => "https://schema.org/InStock"
            ]
        ]);
    }
}
