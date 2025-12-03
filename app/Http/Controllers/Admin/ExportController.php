<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    /**
     * Stream a PDF containing list of products with images.
     */
    public function productsPdf(Request $request)
    {
        $products = Product::with('category')->get();

        $html = view('admin.exports.products_pdf', compact('products'))->render();

        // Prefer barryvdh/laravel-dompdf if available
        if (class_exists('\\Barryvdh\\DomPDF\\Facade\\Pdf')) {
            try {
                $pdf = Pdf::loadHTML($html)->setPaper('a4', 'portrait');
                return $pdf->stream('products.pdf');
            } catch (\Exception $e) {
                return response('PDF generation error: ' . $e->getMessage(), 500);
            }
        }

        // Try to use dompdf directly if installed
        if (class_exists('Dompdf\\Dompdf')) {
            try {
                $dompdf = new \Dompdf\Dompdf();
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $output = $dompdf->output();
                return response($output, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="products.pdf"'
                ]);
            } catch (\Exception $e) {
                return response('PDF generation error: ' . $e->getMessage(), 500);
            }
        }

        // Fallback: instruct to install dompdf
        $msg = "Server-side PDF generation is not available. Please install dompdf or barryvdh/laravel-dompdf:\n\ncomposer require barryvdh/laravel-dompdf\n# or\ncomposer require dompdf/dompdf\n";
        return response(nl2br($msg), 500);
    }

    /**
     * Stream CSV (Excel-compatible) containing profit/revenue per product.
     */
    public function profitExcel(Request $request)
    {
        $products = Product::all();

        $filename = 'product_profit_' . date('Ymd_His') . '.csv';

        $handle = fopen('php://memory', 'w');
        // Header
        fputcsv($handle, ['ID', 'Name', 'Category', 'Price', 'Stock', 'Total Sold', 'Total Revenue', 'Profit']);

        foreach ($products as $p) {
            $totalSold = OrderItem::where('product_id', $p->id)->sum('quantity');
            $totalRevenue = OrderItem::where('product_id', $p->id)->selectRaw('COALESCE(SUM(price * quantity),0) as total')->value('total');
            $totalRevenue = $totalRevenue ?? 0;

            // Profit cannot be computed without cost field. Use totalRevenue as profit placeholder.
            $profit = $totalRevenue;

            fputcsv($handle, [
                $p->id,
                $p->name,
                optional($p->category)->name,
                number_format($p->price, 2, '.', ''),
                $p->stock,
                $totalSold,
                number_format($totalRevenue, 2, '.', ''),
                number_format($profit, 2, '.', ''),
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
