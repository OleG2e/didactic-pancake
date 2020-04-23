<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

class Helpers extends Model
{
    public static function countMyAds(): array
    {
        $user = auth()->user();
        $myTrips = $user->trips()->count();
        $myPosts = $user->posts()->count();
        $myDeliveries = $user->deliveries()->count();

        return compact(['myTrips', 'myPosts', 'myDeliveries']);
    }

    public static function currentCategory(): string
    {
        return \Request::route()->parameter('category');
    }

    public static function countAds(): array
    {
        $trips = Category::where('slug', 'trip')->firstOrFail()->trips()->whereRelevance(true)->count();
        $deliveries = Category::where('slug', 'delivery')->firstOrFail()->trips()->whereRelevance(true)->count();
        $all = Post::whereRelevance(true)->count();
        $buys = Category::where('slug', 'buy')->firstOrFail()->posts()->whereRelevance(true)->count();
        $sells = Category::where('slug', 'sell')->firstOrFail()->posts()->whereRelevance(true)->count();
        $helps = Category::where('slug', 'help')->firstOrFail()->posts()->whereRelevance(true)->count();
        $pets = Category::where('slug', 'pet')->firstOrFail()->posts()->whereRelevance(true)->count();
        $services = Category::where('slug', 'service')->firstOrFail()->posts()->whereRelevance(true)->count();
        $losses = Category::where('slug', 'loss')->firstOrFail()->posts()->whereRelevance(true)->count();

        return compact(
            [
                'all',
                'trips',
                'deliveries',
                'buys',
                'sells',
                'helps',
                'pets',
                'services',
                'losses'
            ]
        );
    }

    public static function isActiveCurrentRoute($route)
    {
        return ($route == Route::currentRouteName()) ? 'is-active' : '';
    }

    public static function filterHelper()
    {
        $orderBy = (\request('orderBy')) ?? 'created_at';
        $direction = (\request('direction')) ?? 'desc';
        $reversedDirection = ($direction === 'desc') ? 'asc' : 'desc';

        return ['direction' => $direction, 'reversedDirection' => $reversedDirection, 'orderBy' => $orderBy];
    }

    public static function imageUpload(string $path = Post::MODEL_NAME): string
    {
        $pathFull = 'uploads/images/full/'.$path.'/'.auth()->user()->username.'/'.date('d-m-Y', time());
        $pathPreview = 'uploads/images/preview/'.$path.'/'.auth()->user()->username.'/'.date('d-m-Y', time());
        $pathAllFiles = [];
        $allImages = request()->allFiles();

        foreach ($allImages as $image) {
            if (is_array($image)) {
                $i = count($allImages['image']) - 1;
                while (isset($image[$i])) {
                    $filenameWithoutSpaces = self::spacesReplace($image[$i]->getClientOriginalName());
                    $pathImagesFull = $image[$i]->storeAs($pathFull, $filenameWithoutSpaces, 'public');
                    $pathImagesPreview = $image[$i]->storeAs($pathPreview, $filenameWithoutSpaces, 'public');
                    Image::make($image[$i]->getRealPath())->widen(512)->save(
                        public_path('storage/'.$pathImagesPreview),
                        70
                    );
                    $pathAllFiles['full'][] = $pathImagesFull;//in production use 'public/'.$pathImagesFull
                    $pathAllFiles['preview'][] = $pathImagesPreview;//in production use 'public/'.$pathImagesPreview
                    $i--;
                }
            }
        }

        return json_encode($pathAllFiles);
    }

    public static function flash($message)
    {
        session()->flash('message', $message);
    }

    public static function isAdmin()
    {
        $user = auth()->user();
        return $user->roles->contains('title', 'admin');
    }

    public static function getImage(
        object $item,
        string $type = 'full',
        int $index = 0,
        string $column = 'images'
    ): string {
        return asset('storage/'.(json_decode($item->$column)->$type)[$index]);
    }

    public static function dateFormat(string $date, string $format = 'H:i d.m.Y'): string
    {
        return date_create($date)->format($format);
    }

    public static function counterTimeRead(string $string): int
    {
        $symbolsPerMinute = 120;
        $coefficient = 15;

        return ((strlen(strip_tags($string))) / $symbolsPerMinute) / $coefficient;
    }

    public static function spacesReplace(string $string): string
    {
        return preg_replace('/\s/i', '_', $string);
    }

    public static function validationMessage(string $fieldName, string $rule, array $options = []): string
    {
        $messages = [
            'required' => "Поле \"{$fieldName}\" обязательно для заполнения!",
            'string' => "Поле \"{$fieldName}\" должно быть строковым значением!",
            'integer' => "Поле \"{$fieldName}\" должно быть числовым значением!",
            'max' => "Поле \"{$fieldName}\" не должно быть длиннее ".($options['length'] ?? '')." символов!",
            'exists' => "Поле \"{$fieldName}\" должно существовать!",
            'date' => "Поле \"{$fieldName}\" должно быть датой!",
        ];
        return $messages[$rule];
    }
}
