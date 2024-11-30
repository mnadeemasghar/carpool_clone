function getLocationSuggestions(id,suggestions,url) {
    const input = document.getElementById(id);
    const suggestionsDiv = document.getElementById(suggestions);
    
    // Disable the input while fetching suggestions
    // input.disabled = true;
    suggestionsDiv.innerHTML = "Searching...";

    const query = input.value;
    
    // Check if the input is not empty
    if (query) {
        fetch(`${url}?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                suggestionsDiv.innerHTML = ''; // Clear previous suggestions

                if (data.length > 0) {
                    const suggestionsList = document.createElement('div');
                    suggestionsList.className = "list-group";
                    data.forEach(location => {
                        const listItem = document.createElement('a');
                        listItem.className = "list-group-item list-group-item-action"; // Adjust based on your API response
                        listItem.textContent = location.title; // Adjust based on your API response
                        listItem.onclick = () => {
                            input.value = location.title; // Set the input value
                            suggestionsDiv.innerHTML = ''; // Clear suggestions
                            // input.disabled = false; // Enable input after selection
                        };
                        suggestionsList.appendChild(listItem);
                    });
                    suggestionsDiv.appendChild(suggestionsList);
                } else {
                    suggestionsDiv.innerHTML = '<p class="text-muted">No suggestions found.</p>';
                }
                input.disabled = false; // Re-enable the input after fetching suggestions
            })
            .catch(error => {
                console.error('Error fetching location suggestions:', error);
                input.disabled = false; // Re-enable input in case of error
            });
    } else {
        suggestionsDiv.innerHTML = ''; // Clear suggestions if input is empty
        input.disabled = false; // Re-enable input if no query is present
    }
}