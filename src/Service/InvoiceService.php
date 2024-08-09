<?php

namespace App\Service;

use App\Entity\Order;
use Dompdf\Dompdf;
use Twig\Environment;

class InvoiceService
{

    public function __construct(private Environment $twig) {}

    public function generateInvoice(Order $order)
    {
        $invoice = $this->twig->render('front/invoice/template.html.twig', [
            'order' => $order
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($invoice);
        $dompdf->render();
        return $dompdf->output();
    }
}
