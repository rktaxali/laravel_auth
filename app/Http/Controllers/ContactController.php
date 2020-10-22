<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Jobs\SendEmail;

class ContactController extends Controller
{
    // Displays a form (to sent email)
    public function show()
    {
        return view('contact'); 
    }

    //  Sends email form (to sent email)
    public function store()
    {
         // validate request('email'): reuired and of type email
        request()->validate(['email'=>'required|email']);
        // Note: If validataon fails, Laravel will return back to the form with error message
        // Subsequest code in this funtion will not be executed.
        

        // Sending email using app/Mail/ContactMe.php class
       // \Mail::to(request('email'))->send(new \App\Mail\ContactMe);

      

        // passing data to the ContactMe class 
        // Sends the email immidiately using the Mail class
        /*   
        $details['topic'] = 'Shirt';
        \Mail::to(request('email'))->send(new \App\Mail\ContactMe($details));
        return redirect('/contact')->with('message', 'Email Sent!');
        */

        // Sending the email to the queue using the SendEmail class.
        // The handle() method send the email to the queue
        $details['topic'] = 'Shirt';
        $details['email'] = request('email');
        $details['subject'] = request('subject');
        
        // (0): Directly calls the SendEmail->handle(), bypassing the Job queue 
       // $emailJob = new \App\Jobs\SendEmail($details);
       // $emailJob->handle();
    

        // (a) Dispatch immidiately, The job is put in the jobs queue. 
        // If queue work is running (e.g. php artisan queue:work), the job will be processed immidiately
        /*
        $emailJob = new \App\Jobs\SendEmail($details);
        $emailJob->dispatch($details);
        */

        // Dispatch immidiately: Same as (a)
       // \App\Jobs\SendEmail::dispatch($details);

       // (c) delayed dispatch adter 2 minutes: Job will be entered in the queue to be processed after one minute
       \App\Jobs\SendEmail::dispatch($details)->delay(now()->addMinutes(2));

        // (d) Synchronous dispatch
       // \App\Jobs\SendEmail::dispatchSync($details)        ; // email sent immidiately. (Not put in Queue)

        return redirect('/contact')->with('message', 'Email Sent!');

    }
}

