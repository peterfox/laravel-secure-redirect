<?php

namespace App;

use Illuminate\Support\Str;

class Redirector extends \Illuminate\Routing\Redirector
{
    public function back($status = 302, $headers = [], $fallback = false)
    {
        $url = $this->generator->previous($fallback);

        if (!Str::startsWith($url, config('app.url'))) {
            $url = url()->route('welcome');
        }

        return $this->createRedirect($url, $status, $headers);
    }

}
