<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pesanan;
use Carbon\Carbon;

class BatalkanPesananExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:batalkan-pesanan-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel order that passed payment time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expiredOrders = Pesanan::where('status', 'Menunggu Pembayaran')
            ->where('batas_waktu_pembayaran', '<', now())
            ->get();

        foreach ($expiredOrders as $pesanan) {
            $pesanan->status = 'Dibatalkan';
            $pesanan->save();

            $this->info("Pesanan {$pesanan->nomor_pesanan} dibatalkan otomatis.");
        }
    }
}
