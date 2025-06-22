<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DailySalesSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-sales-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genereert dagelijks een Excel-samenvatting van de verkoop.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        $orders = Order::with(['orderItems.dish', 'user'])
            ->whereDate('created_at', $today)
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Order ID');
        $sheet->setCellValue('B1', 'Gebruiker');
        $sheet->setCellValue('C1', 'Tijd');
        $sheet->setCellValue('D1', 'Totaal');

        $row = 2;
        $total = 0;
        foreach ($orders as $order) {
            $sheet->setCellValue('A' . $row, $order->id);
            $sheet->setCellValue('B' . $row, $order->user ? $order->user->name : 'Onbekend');
            $sheet->setCellValue('C' . $row, $order->created_at->format('H:i'));
            $sheet->setCellValue('D' . $row, $order->total_price);
            $total += $order->total_price;
            $row++;
        }
        $sheet->setCellValue('C' . $row, 'Totaal omzet:');
        $sheet->setCellValue('D' . $row, $total);

        // Sla bestand op via de Storage facade zodat het zichtbaar is voor de controller en download route
        $filename = 'sales_summary_' . $today->format('Y_m_d') . '.xlsx';
        $storagePath = 'summaries/' . $filename;
        // Zorg dat de map bestaat
        if (!Storage::exists('summaries')) {
            Storage::makeDirectory('summaries');
        }
        // Sla het bestand op via Storage (local disk)
        $tempPath = sys_get_temp_dir() . '/' . $filename;
        $writer = new Xlsx($spreadsheet);
        $writer->save($tempPath);
        Storage::put($storagePath, file_get_contents($tempPath));
        @unlink($tempPath);

        $this->info('Samenvatting succesvol opgeslagen: ' . $filename);
    }
}
