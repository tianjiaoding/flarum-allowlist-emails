<?php

namespace WhitelistEmails;

use Flarum\Extend;
use Flarum\Foundation\ValidationException;
use Flarum\User\Event\Saving;
use Illuminate\Support\Arr;

return [
    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Event())
        ->listen(Saving::class, function (Saving $event) {
            $email = Arr::get($event->data, 'attributes.email');
            
            if (!empty($email)) {
                $domain = substr( strrchr( $email, "@" ), 1 );
                $whitelist = array( 'shanghaitech.edu.cn' );
                if( ! in_array( $domain, $whitelist ) ) { 
                    throw new ValidationException([
                        resolve('translator')->trans('whitelist-email.error.message'),
                    ]);
                }
            }
        }),
];
