<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderProcessed extends Mailable
{
    use Queueable, SerializesModels;
    public $ord;
    public $order_details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $details)
    {
        $this->ord = $order;
        $this->order_details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ventas Gerizim - Pedido Procesado')
                    ->markdown('emails.orders.processed', [
                        'order' => $this->ord, 
                        'order_details' => $this->order_details
                    ]);
    }
}
