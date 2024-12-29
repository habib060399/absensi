<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Dompdf\Dompdf;
use App\Http\Controllers\Controller;
use PDF;
use App\Helpers\Helper;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoice = Invoice::join('sekolah', 'sekolah.id', '=', 'invoice.id_sekolah')->select('invoice.*', 'sekolah.nama_sekolah')->get();

        return view('admin.list_invoice',[
            'invoice' => $invoice
        ]);
    }

    public function showInvoice($id)
    {
        $invoice = Invoice::join('sekolah', 'sekolah.id', '=', 'invoice.id_sekolah')->where('invoice.id', '=', Helper::decryptUrl($id))->select('invoice.*', 'sekolah.nama_sekolah')->first();
        $serialize = serialize($invoice->paket_detail);
        $unserialize = unserialize($serialize);
        $data = json_decode($unserialize);
        $paket_detail = '';
        foreach ($data->data as $d){
            $paket_detail .= "$d->text, ";
        }

        return view('admin.invoice',[
            'invoice' => $invoice,
            'paket_detail' => $paket_detail
        ]);
    }

    public function generateInvoicePDF($id)
    {
        $invoice = Invoice::join('sekolah', 'sekolah.id', '=', 'invoice.id_sekolah')->where('invoice.id', '=', Helper::decryptUrl($id))->select('invoice.*', 'sekolah.nama_sekolah')->first();
        $serialize = serialize($invoice->paket_detail);
        $unserialize = unserialize($serialize);
        $data = json_decode($unserialize);
        $paket_detail = '';
        foreach ($data->data as $d){
            $paket_detail .= "$d->text, ";
        }

        $pdf = new Dompdf();
        $html = view('admin.invoice_pdf',['invoice' => $invoice, 'paket_detail' => $paket_detail])->render();
        $pdf->loadHtml($html);
        $pdf->setPaper('letter', 'landscape');
        $pdf->render();
        return $pdf->stream('invoice_flockbase.pdf');
    }

    public function store()
    {

    }
}
