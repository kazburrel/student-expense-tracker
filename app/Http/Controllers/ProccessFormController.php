<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class ProccessFormController extends Controller
{
    public function getCategories()
    {
        return Category::all();
    }

    public function reviewForm(Request $request)
    {
        try {
            $request->validate([
                'customImage' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
        $image = $request->file('customImage');
        // dd($image);
        $categories = Category::all()
            ->map(function ($category) {
                return [
                    'slug' => $category->slug,
                    'keywords' => $category->keywords
                ];
            })
            ->toJson();
        $response = OpenAI::chat()->create([
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
    
                            Provide the information as a JSON object containing the following keys:
                            - `store`: Indicate the name of the business or store from which the receipt originates. Adjust the spelling or capitalization if it is incorrect.
                            - `amount`: Provide the total amount of the receipt without using commas or currency symbols. If uncertain, leave this field empty string; without attempting to compute it. Additionally, if a clubcard price is identified, the total price should be chosen since that reflects what the buyer paid.
                            - `description`: A brief overview of the items bought.
                            - `category`: When determining the appropriate, choose from the available options ($categories) based on the item's relevance. If an item appears to fit into multiple categories, list them accordingly. If you find the ideal category missing, create one using your own descriptor, accompanied by a notation indicating your authorship.
    
                            If you are unsure about any values, set them to an empty string.
                        "
                        ],
                        [
                            'type' => 'image',
                            'image' => base64_encode(file_get_contents($image))
                        ]
                    ]
                ]
            ]
        ]);

        $json = $response->choices[0]->message->content;
        $json = Str::markdown($json);
        $json = strip_tags($json);
        $json = html_entity_decode($json);
        $data = json_decode($json, true);
        return response()->json($data);
    }
}
