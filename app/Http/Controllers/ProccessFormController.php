<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI;

class ProccessFormController extends Controller
{
    public function reviewForm(Request $request)
    {
        Log::info('Request data:', $request->all());

        $client = OpenAI::client(config('openai.key'));

        $response = $client->chat()->create([
            'model' => 'gpt-4-vision-preview',
            'max_tokens' => 1000,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'Provide JSON output without any Markdown formatting or additional text.'
                        ]
                    ]
                ],
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => "
                            Please extract information from the receipt and provide JSON output, ensuring no additional text or Markdown formatting is included.

                        Return the data as a JSON object with the following keys:
                        - `store`: The name of the business or store the receipt is from. Correct it if it isn't properly spelled or capitalized.
                        - `amount`: The grand total of the receipt without commas or currency symbols. If you are unsure, set this to an empty string; do not attempt to calculate it.
                        - `description`: A general description of what was purchased.
                        - `category`: Whichever category is most appropriate ($categories).

                        If you are unsure about any values, set them to an empty string.
                    "
                        ],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                // 'url' => $url,
                                'detail' => 'low'
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}
