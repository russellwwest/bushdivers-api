<?php

namespace App\Services;

use App\Models\User;
use Mailjet\Client;
use Mailjet\Resources;

class MailService
{
    public function generateEmail(string $type, $model): array
    {
        $body= [];
        switch ($type) {
            case 'register':
                $body = $this->generateRegistrationEmail($model);
        }
        return $body;
    }

    public function sendEmail(array $body): void
    {
        $key = env('MAILJET_KEY', 'test');
        $secret = env('MAILJET_SECRET', 'test');
        $mailer = new Client($key, $secret, true, ['version' => 'v3.1']);
        $mailer->post(Resources::$Email, ['body' => $body]);
    }

    protected function generateRegistrationEmail(User $user): array
    {
        $data = [
            'name' => $user->name,
            'pilot_id' => $user->pilot_id
        ];
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "admin@bushdivers.com",
                        'Name' => "Bush Divers Team"
                    ],
                    'To' => [
                        [
                            'Email' => $user->email,
                            'Name' => $user->name
                        ]
                    ],
                    'TemplateID' => 3180087,
                    'TemplateLanguage' => true,
                    'Subject' => "Welcome to Bush Divers",
                    'Variables' => $data
//                    'Variables' => json_decode('{
//                        "name": "",
//                        "pilot_id": ""
//                      }', true)
                ]
            ]
        ];

        return $body;
    }
}
