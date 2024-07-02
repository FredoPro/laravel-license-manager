<?php

namespace FredoAntonio\License\Http\Middleware;
use Closure;
use FredoAntonio\License\Configuration;
use Carbon\Carbon;
use FredoAntonio\License\Token;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;

class CheckTokenMiddleware 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     public function save($secretKey){

        
        $now = Carbon::now();
        $date = $now->toDateString();
 
        $token = Token::encryptLicenseData('', $date, $secretKey);
        $data['payload'] = $token;
        $data['status'] = 1;
       
        $payload = $this->check($secretKey);
      
        $config = Configuration::find(1);
        if(($payload['end_date'] < $date) && $config->status == 1){
           
            
            $config->update($data);
         
       

         }
        
   
     }

     public function check($secretKey){

        $config = Configuration::first();
        $payload = Token::decryptLicenseData($config->payload, $secretKey);
        
         return $payload;
   
     }
    public function handle($request, Closure $next)

    {    
        

        $encryptedLicense = Config::get('tokendata.secret_data');
        $secretKey = Config::get('tokendata.secret_key');
       


        $this->save($secretKey);
        $payload =$this->check($secretKey);
         
        
        try {
            $licenseData = Token::decryptLicenseData($encryptedLicense, $secretKey);

            $startDate = $licenseData['start_date'];
            $endDate = $licenseData['end_date'];

            
            if ($payload['end_date'] < $startDate || $payload['end_date'] > $endDate) {
                
                $config = Configuration::find(1);
                $config->update(['status' => 0]);
                throw new \Exception('License expired or invalid.');
            }
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], 403);
        }

        return $next($request);
    }

}
