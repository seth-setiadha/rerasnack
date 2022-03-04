<?php

namespace App\Jobs;

use App\Exports\RerasnackExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ReportDetailJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $dateFrom;
    protected $dateTo;

    public $tries = 3;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from, $to)
    {
        $this->dateFrom = $from;
        $this->dateTo = $to;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // throw new \Exception('Failed');
        Excel::store(new RerasnackExport($this->dateFrom, $this->dateTo), '/reports/detail-from-' . date('d', strtotime($this->dateFrom)) . "-sd-" . date('d-m-Y', strtotime($this->dateTo)) . '.xlsx');
    }

    public function failed(\Throwable $e) {
        info('This job has failed');
    }
}
