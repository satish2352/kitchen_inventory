<?php 
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $password;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $email_data = [
                'email' => $this->email,
                'password' => $this->password,
            ];
            $toEmail = $this->email;
            $senderSubject = 'Credentials for the Buffalo Boss login ' . date('d-m-Y H:i:s');
            $fromEmail = env('MAIL_FROM_ADDRESS');

            Mail::send('user_added_mail', ['email_data' => $email_data], function ($message) use ($toEmail, $fromEmail, $senderSubject) {
                $message->to($toEmail)->subject($senderSubject);
                $message->from($fromEmail, 'Buffalo Boss');
            });

        } catch (\Exception $e) {
            \Log::error('Mail sending error: ' . $e->getMessage());
        }
    }
}
