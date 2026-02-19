<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\View\View;

class NewsletterSubscriberController extends Controller
{
    public function index(): View
    {
        $subscribers = NewsletterSubscriber::orderByDesc('subscribed_at')->paginate(50);
        return view('admin.newsletter.index', compact('subscribers'));
    }
}
