<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Process the request and get the response
        $response = $next($request);

        // Capture the request details
        $ip = $request->ip();
        $identity = $request->get('REMOTE_USER', '-'); // Not available in Laravel, usually "-"
        $remoteUser = auth()->check() ? auth()->user()->id : '-'; // Not available in Laravel, usually "-"
        $datetime = date('d/M/Y:H:i:s O');
        $method = $request->method();
        $path = $request->fullUrl();
        $httpVersion = $request->server('SERVER_PROTOCOL');
        
        // TODO: following null check is for the error caused by the status(),
        // Call to undefined method Symfony\Component\HttpFoundation\BinaryFileResponse::status()
        // "exception": "[object] (Error(code: 0): 
        // Call to undefined method Symfony\\Component\\HttpFoundation\\BinaryFileResponse::status() 
        // at /home/u448904343/domains/carpoollahore.com/public_html/app/Http/Middleware/LogAccess.php:23)
        // $statusCode = $response?->status() ?? "200";

        if ($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
            $statusCode = $response->getStatusCode();
        } elseif (method_exists($response, 'status')) {
            $statusCode = $response->status();
        } else {
            // Fallback status code if the response doesn't match the expected types
            $statusCode = 200;
        }

        $contentLength = $response->headers->get('Content-Length', '-');
        $referrer = $request->headers->get('referer', '-');
        $userAgent = $request->header('User-Agent', '-');

        // Format the log entry
        $logEntry = sprintf(
            "%s %s %s [%s] \"%s %s %s\" %s %s \"%s\" \"%s\"\n",
            $ip,
            $identity,
            $remoteUser,
            $datetime,
            $method,
            $path,
            $httpVersion,
            $statusCode,
            $contentLength,
            $referrer,
            $userAgent
        );

        // Get request headers
        $headers = $request->headers->all();
    
        // Get request data (input)
        $data = $request->all();
    
        // Compile both headers and request data into one array
        $compiledData = [
            'headers' => $headers,
            'data' => $data,
        ];

        // Log to a custom log file
        Log::channel('access')->info($logEntry,$compiledData);

        return $response; // Return the response back to the application
    }
}
