<?php


namespace App\Helpers;


use App\Helpers;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class MapHelper
{
    private static array $icons = [
        'pet' => [
            'color' => 'red',
            'label' => 'Dog',
        ],
        'help' => [
            'color' => 'red',
            'label' => 'Heart',
        ],
        'trip' => [
            'color' => 'blue',
            'label' => 'Auto',
        ],
        'delivery' => [
            'color' => 'blue',
            'label' => 'Delivery',
        ],
        'service' => [
            'color' => 'blue',
            'label' => 'Money',
        ],
        'loss' => [
            'color' => 'blue',
            'label' => 'Info',
        ],
        'buy' => [
            'color' => 'blue',
            'label' => 'Court',
        ],
        'sell' => [
            'color' => 'blue',
            'label' => 'Court',
        ],
        'ad' => [
            'color' => 'blue',
            'label' => 'Info',
        ],
    ];

    private static function templateIcons(string $color, string $label): string
    {
        return "islands#{$color}{$label}Icon";
    }

    /**
     * @see https://tech.yandex.ru/maps/jsapi/doc/2.1/ref/reference/option.presetStorage-docpage/
     * @param  string  $categorySlug
     * @return string
     */
    public static function getIcon(string $categorySlug): string
    {
        if (isset(self::$icons[$categorySlug])) {
            return self::templateIcons(self::$icons[$categorySlug]['color'], self::$icons[$categorySlug]['label']);
        } else {
            return self::templateIcons(self::$icons['ad']['color'], self::$icons['ad']['label']);
        }
    }

    public static function getPoints(Collection $posts): Collection
    {
        $points = collect();
        $posts->flatten()
            ->each(
                function ($post) use ($points) {
                    $icon = self::getIcon($post->category->slug);
                    $description = Str::words($post->description, 5);
                    $link = route('post.show', [$post->category->slug, $post]);
                    $hint = $post->category->title;
                    if ($post->countImages()) {
                        $image = Helpers::getImage($post, 'preview');
                    }
                    if ($post->point->latitude) {
                        if (!empty($image)) {
                            $point = "{'coords': [{$post->point->latitude}, {$post->point->longitude}],'balloon':{balloonContentHeader: '{$post->title}',balloonContentBody: '<figure class=\"image is-128x128\"><a href=\'{$link}\'><img src=\"{$image}\" alt=\'{$post->title}\'></a></figure>{$description}',balloonContentFooter: '<a href=\"{$link}\">Подробнее</a>',hintContent: '{$hint}'},'preset': '{$icon}'}";
                        } else {
                            $point = "{'coords': [{$post->point->latitude}, {$post->point->longitude}],'balloon':{balloonContentHeader: '{$post->title}',balloonContentBody: '{$description}',balloonContentFooter: '<a href=\"{$link}\">Подробнее</a>',hintContent: '{$hint}'},'preset': '{$icon}'}";
                        }
                        $points->push($point);
                    }
                }
            );
        return $points;
    }
}