<?php
namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Comment;
use App\Models\Ride;
use App\Models\Stop;
use App\Models\User;
use App\Services\RideService;
use App\Services\StopService;
use App\Traits\Blogable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    use Blogable;

    protected $rideService;
    protected $stopService;

    public function __construct(RideService $rideService, StopService $stopService)
    {
        $this->rideService = $rideService;
        $this->stopService = $stopService;
    }

    public function welcome(Request $request){
        // $pickAddresses = $this->stopService->getStopAddresses();
        // $rides = $this->rideService->getSearchedRides($request);

        // total users count
        $users = User::count();
        // total ride created so far
        $rides = Ride::count();

        // popolar addresses
        $addresses = Address::withCount('rides')->orderBy('rides_count','DESC')->limit(10)->get();

        return view('welcome',compact(
            'users',
            'rides',
            'addresses'
        ));
    }

    public function faqs(){
        $content = "";
        $page = "Frequently Asked Questions";

        // Question 1
        $content .= "<strong>What is carpooling?</strong>";
        $content .= "<p>Carpooling is the practice of sharing a car journey with others to reduce costs, traffic, and environmental impact. It involves sharing rides with other people traveling to the same destination or nearby locations.</p>";

        // Question 2
        $content .= "<strong>How do I find a carpool ride?</strong>";
        $content .= "<p>You can find carpool rides by using our platform, carpoollahore.com. Simply search for rides based on your starting location and destination. You can contact drivers who have listed rides that match your route.</p>";

        // Question 3
        $content .= "<strong>Is carpooling safe?</strong>";
        $content .= "<p>We encourage all users to take necessary precautions when carpooling, such as confirming driver identities, sharing your travel details with family or friends, and meeting in public places when possible.</p>";

        // Question 4
        $content .= "<strong>How much does it cost to carpool?</strong>";
        $content .= "<p>The cost of carpooling is typically shared among passengers to cover fuel expenses. Exact costs may vary depending on the distance and agreement between the driver and passengers.</p>";

        // Question 5
        $content .= "<strong>Do I need to sign up to carpool?</strong>";
        $content .= "<p>Yes, creating an account on carpoollahore.com is necessary to access ride listings, contact drivers, and manage your carpooling options effectively.</p>";

        // Question 6
        $content .= "<strong>Can I offer rides as a driver?</strong>";
        $content .= "<p>Yes, if you have a vehicle, you can offer rides to passengers traveling in the same direction. Simply create a listing with your route details.</p>";

        // Question 7
        $content .= "<strong>What are the benefits of carpooling?</strong>";
        $content .= "<p>Carpooling saves money, reduces traffic congestion, helps the environment, and can also be a way to meet new people and make commuting more enjoyable.</p>";

        return $this->blogPage($page, $content);
    }

    function aboutUs(){
        $page = "About Us";
        $content = "";

        // Section 1
        $content .= "<strong>Who We Are</strong>";
        $content .= "<p>We are a dedicated team of web developers, each with a unique set of skills and a shared passion for contributing to the digital world. With years of experience across various platforms and frameworks, we work together to create efficient, scalable, and user-friendly web applications that positively impact communities and help businesses grow. Our mission is to leverage technology to provide effective, real-world solutions to everyday challenges.</p>";

        // Section 2
        $content .= "<strong>Our Vision</strong>";
        $content .= "<p>At Carpool Lahore, we envision a future where commuting is not just a necessity but an enjoyable and environmentally-friendly experience. We believe in the power of shared transportation to reduce traffic congestion, lower carbon emissions, and foster a sense of community among users. Our goal is to facilitate connections among individuals, making travel easier and more accessible for everyone.</p>";

        // Section 3
        $content .= "<strong>Open Source and Community-Driven</strong>";
        $content .= "<p>As an open-source project, Carpool Lahore is built by and for the community. We are committed to maintaining a platform that is free for all users, ensuring that everyone has access to our services without any barriers. However, to sustain our operations and cover the costs of server maintenance, we may introduce a minimal monthly subscription. This small fee will help us continue to provide you with a reliable and feature-rich platform while keeping the service free for all.</p>";

        // Section 4
        $content .= "<strong>Join Us</strong>";
        $content .= "<p>We invite you to join our community of users who are passionate about sustainable transportation. Whether you’re looking to share a ride, reduce your carbon footprint, or connect with fellow commuters, Carpool Lahore is here for you. Together, let’s make our roads safer, cleaner, and more connected!</p>";

        $content .= "<strong>Contact Us</strong>";
        $content .= "<p>If you have any questions, feedback, or would like to contribute to our project, feel free to reach out. Your input is invaluable as we strive to improve and expand our services.</p>";

        return $this->blogPage($page, $content);
    }

    public function contactUs()
    {
        $page = "Contact Us";
        $content = "";
        
        $content .= "<h2>We're Here to Help!</h2>";
        $content .= "<p>Have a question, suggestion, or just want to say hello? We'd love to hear from you! Reach out to us on any of our platforms, and our team will get back to you as soon as possible.</p>";
        
        // Social Links
        $content .= "<h4>Connect with Us:</h4>";
        $content .= "<ul style='list-style: none; padding: 0;'>";
        
        // $content .= "<li><strong>Facebook:</strong> <a href='https://facebook.com/YourPage' target='_blank'>facebook.com/YourPage</a></li>";
        $content .= "<li><strong>LinkedIn:</strong> <a href='https://www.linkedin.com/company/carpool-lahore' target='_blank'>linkedin.com/company/carpool-lahore</a></li>";
        
        $content .= "</ul>";
        
        $content .= "<p>We’re excited to connect with you!</p>";
        
        return $this->blogPage($page,$content);
    }

    public function siteMap()
    {
        Sitemap::create()
            ->add(Url::create('/'))
            ->add(Url::create('/ride/create'))
            ->add(Url::create('/register'))
            ->add(Url::create('/faqs'))
            ->add(Url::create('/about-us'))
            ->add(Url::create('/contact-us'))
            ->add(Url::create('/terms-of-service'))
            ->add(Url::create('/privacy-policy'))
            ->writeToFile(public_path('sitemap.xml'));
    }
}
