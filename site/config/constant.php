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
        'subject'=>'[No-Reply] Confirm Registration - Media Center Network',
        'content'=>'Hi {full_name},<p></p> Please click below link to confirm account.<br/> {activated_link}<p></p>This activated link can only operate in 24 hours<p></p>Sincerely,<br/>MCenterNTW Team',
    ],
    'forgot' =>[
        'email'=>'no-replay@mcenterntw.com',
        'name'=>'Media Center Network',
        'subject'=>'[No-Reply] Forgot Password - Media Center Network',
        'content'=>'Hi {full_name},<p></p> New Password: {password}<p></p>Please login your dashboard and change your password.<p></p>Sincerely,<br/>MCenterNTW Team',
    ],
    'confirm_payment' =>[
        'email'=>'no-replay@mcenterntw.com',
        'name'=>'Media Center Network',
        'subject'=>'[No-Reply] Confirm Payment Email - Media Center Network',
        'content'=>'Hi {full_name},<p></p> Please click below link to confirm account.<br/> {confirm_link}<p></p>This confirmation link can only operate in 24 hours<p></p>Sincerely,<br/>MCenterNTW Team',
    ],
    'confirm_payment_success' =>[
        'email'=>'no-replay@mcenterntw.com',
        'name'=>'Media Center Network',
        'subject'=>'[No-Reply] Congratulations! Sign contract successfully - Media Center Network',
        'content'=>'Hi {full_name},<p></p> Congratulations!<br/>You had signed contract successfully.<p></p>Sincerely,<br/>MCenterNTW Team',
    ]
];