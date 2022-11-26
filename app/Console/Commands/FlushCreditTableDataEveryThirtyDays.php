<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Credit;
use Carbon\Carbon;

class FlushCreditTableDataEveryThirtyDays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:flushCT'; // flush Credit Table

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command clears every 30 days credit table data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $todayDate = Carbon::now();
        $today = $todayDate->format('Y-m-d');
        $creditTable = Credit::where('expiredAt', '=', $today)->delete();
        // $creditTable = Credit::where('expiredAt', '=', $today)->update([
        //     'totalCredit' => 0
        // ]);
    }
}
