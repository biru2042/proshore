<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Library\GeneralLibrary;

class Campaign extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign'; // flush Credit Table

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'campaign';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('campaigns start');

        $results = DB::table('broadcast')
        ->where('variable','campaignLogId')
        ->groupBy('callUniqueId')
        ->limit(50)
        ->get();

        if ($results) {

            foreach ($results as $result) {
                $res = DB::table('broadcast')
                ->where('callUniqueId',$result->callUniqueId)
                ->where('cause','!=','dblank')
                ->first();

                if ( $res ) {
                    $status  = $this->getStatus( $res->cause );
                    Log::info('campaigns start id '.$result->value);
                     Log::info('campaigns start cause '.$res->cause);
                     Log::info('campaigns start causeTxt '.$res->causeTxt);

                    /*get detail*/
                    $campaignLogDetail = DB::table('campaign_logs')
                    ->where('id',$result->value)
                    ->first();

                    $campaignDetail = DB::table('campaigns')
                    ->where('id',$campaignLogDetail->campaignId)
                    ->first();

                    $campaingRetryStatus = json_decode($campaignDetail->status);

                    $scheduleTime = $campaignLogDetail->scheduleTime;

                    if ( $campaignLogDetail->noOfRetries + 1 < $campaignLogDetail->maxNoOfRetries) {
                        if(in_array( $status, $campaingRetryStatus )) {
                            $scheduleTime = GeneralLibrary::addSecToTime(Date('Y-m-d H:i:s'),$campaignDetail->retryInterval*60);
                        }
                    }

                    DB::table('campaign_logs')
                    ->where('id',$result->value)
                    ->update([
                        'status'=>$status,
                        'scheduleTime'=>$scheduleTime,
                        'noOfRetries'=>$campaignLogDetail->noOfRetries + 1,
                        'updated_at'=>Date('Y-m-d H:i:s')
                    ]);

                    /*delete*/
                    DB::table('broadcast')
                    ->where('callUniqueId',$result->callUniqueId)
                    ->delete();
                }
                
            }
        }


        
        
        

        
    }


    private function getStatus( $code  )
    {
        switch ( $code ) {
            case '0':
                return $status = "noAnswer";
                break;

            case '1':
                return $status = "invalidDid";
                break;

            case '16':
                return $status = "deliver";
                break;

            case '17':
                return $status = "busy";
                break;

            case '18':
                return $status = "noAnswer";
                break;

            case '19':
                return $status = "noAnswer";
                break;

            case '21':
                return $status = "cancel";
                break;

            case '27':
                return $status = "destOutOfOrder";
                break;

            case '28':
                return $status = "invalid";
                break;

            case '38':
                return $status = "networkOutOfOrder";
                break;

            case '54':
                return $status = "incomingCallBarred";
                break;
            
            
            default:
                return $status = "others";
                break;

             
        }
    }
}
