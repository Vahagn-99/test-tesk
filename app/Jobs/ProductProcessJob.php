<?php

namespace App\Jobs;

use App\Mail\ProductSendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProductProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $send;
    protected $product;
    protected $message = '';
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($send, $product, $message)
    {
        $this->product = $product;
        $this->message = $message;
        $this->send = $send;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->send)->send(new ProductSendMail($this->product, $this->message));
    }
}
