<?php
namespace App\Traits;

trait Sortable
{
    public function getSortedQuery($request,$query, $sortableColumns)
    {
        return $query->when($request->has('sort'), function ($query) use ($request, $sortableColumns) {
            $sortOptions = $request->input('sort', []); // Expecting an associative array, e.g., ['title' => 'asc', 'id' => 'desc']
    
            // Loop through each sort option in the array
            foreach ($sortOptions as $column => $direction) {
                // Check if the column is in the allowed list and if the direction is valid
                if (in_array($column, $sortableColumns) && in_array(strtolower($direction), ['asc', 'desc'])) {
                    $query->orderBy($column, $direction);
                }
            }
        }, function ($query) {
            // Default sorting if no valid sort parameter is provided
            $query->orderBy('id', 'asc');
        });    
    }
}