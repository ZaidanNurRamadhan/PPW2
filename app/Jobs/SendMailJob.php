<?php

namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
    $this->data = $data;}
    /**
     * Execute the job.
     */
    public function handle(): void
{
    $email = new SendMail([
        'name' => $this->data['name'],    // Nama penerima
        'body' => $this->data['message'], // Isi pesan
        'subject' => $this->data['subject']
    ]);
    Mail::to($this->data['email'])->send($email);
}

}
