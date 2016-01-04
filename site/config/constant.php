<?php
return [
    'registration' => [
        'site' => 1,
        'dailymotion' => 2,
        'facebook' => 3,
        'google' => 4,
    ],
    'confirmation' =>[
        'email'=>'no-replay@mcenterntw.com',
        'name'=>'Media Center Network',
        'subject'=>'[Confirm Registration] No-Reply',
        'content'=>'Hi {full_name},<p></p> Please click below link to confirm account.<br/> {activated_link}<p></p>This activated link can only operate in 24 hours<p></p>Sincerely,<br/>MCenterNTW Team',
    ]
];