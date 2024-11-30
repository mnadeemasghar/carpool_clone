<?php
namespace App\Services;

use App\Models\Quote;
use Illuminate\Support\Facades\Http;

class QuoteService
{
    private $category;
    private $allCategories = [
        "age",
        "alone",
        "amazing",
        "anger",
        "architecture",
        "art",
        "attitude",
        "beauty",
        "best",
        "birthday",
        "business",
        "car",
        "change",
        "communication",
        "computers",
        "cool",
        "courage",
        "dad",
        "dating",
        "death",
        "design",
        "dreams",
        "education",
        "environmental",
        "equality",
        "experience",
        "failure",
        "faith",
        "family",
        "famous",
        "fear",
        "fitness",
        "food",
        "forgiveness",
        "freedom",
        "friendship",
        "funny",
        "future",
        "god",
        "good",
        "government",
        "graduation",
        "great",
        "happiness",
        "health",
        "history",
        "home",
        "hope",
        "humor",
        "imagination",
        "inspirational",
        "intelligence",
        "jealousy",
        "knowledge",
        "leadership",
        "learning",
        "legal",
        "life",
        "love",
        "marriage",
        "medical",
        "men",
        "mom",
        "money",
        "morning",
        "movies",
        "success"
    ];

    public function __construct()
    {
        $randomKey = array_rand($this->allCategories, 1);
        $this->category = $this->allCategories[$randomKey];
    }
    public function getQuotes(){
        return $this->getQuoteByCategory($this->category);
    }

    public function getQuoteByCategory($category)
    {
        // Fetch API Key from .env
        $apiKey = env('API_NINJAS_KEY');
        
        // API URL
        $apiUrl = "https://api.api-ninjas.com/v1/quotes?category={$category}";

        // Make the API request
        $response = Http::withHeaders([
            'X-Api-Key' => $apiKey
        ])->get($apiUrl);

        // Check for successful response
        if ($response->successful()) {

            $all_quotes = $response->json();

            foreach($all_quotes as $quote){
                // Quote::create($quote);
                Quote::create([
                    'quote' => $quote['quote'] ?? "N/A",
                    'author' => $quote['author'] ?? "N/A",
                    'category' => $quote['category'] ?? "N/A",
                ]);

            }

            return $all_quotes;  // Return the quote data as an array
        } else {
            return [
                'error' => true,
                'status_code' => $response->status(),
                'message' => 'Error fetching the quote: ' . $response->body()
            ];
        }
    }
}
